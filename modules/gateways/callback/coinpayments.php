<?php
/**
 * CoinPayments WHMCS Gateway Callback Handler
 *
 * Handles CoinPayments webhook callbacks for WHMCS payment reconciliation.
 *
 * @package    CoinPayments_WHMCS_Gateway
 * @author     CoinPayments
 * @copyright  Copyright (c) CoinPayments
 * @license    See LICENSE file
 * @version    1.0.0
 * @link       https://www.coinpayments.net/
 *
 * For full license terms, see the LICENSE file included with this repository.
 */

require_once __DIR__ . '/../coinpayments/lib/api.php';
require_once __DIR__ . '/../../../init.php';

$whmcs->load_function('gateway');
$whmcs->load_function('invoice');

$gatewayModule = COINPAYMENTS_MODULE_NAME;
$params = getGatewayVariables($gatewayModule);

if (empty($params['type'])) {
    http_response_code(404);
    exit('Module Not Activated');
}

if (($params['coinpayments_webhooks'] ?? '') !== 'on') {
    http_response_code(204);
    exit;
}

$rawBody = file_get_contents('php://input') ?: '';
$headers = coinpayments_getallheaders();

try {
    $verification = coinpayments_verify_webhook($params, $rawBody, $headers);
    if (!$verification->ok) {
        logTransaction($gatewayModule, array('reason' => $verification->reason, 'body' => $rawBody), 'Webhook Signature Failed');
        http_response_code(401);
        exit('Invalid signature');
    }

    $payload = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
    $invoicePayload = coinpayments_extract_callback_invoice($payload);

    $merchantInvoiceId = $invoicePayload['invoiceId']
        ?? $invoicePayload['merchantInvoiceId']
        ?? coinpayments_array_get($invoicePayload, array('customData', 'merchantInvoiceId'));

    if (empty($merchantInvoiceId) || !is_string($merchantInvoiceId)) {
        throw new RuntimeException('Webhook payload does not contain a merchant invoice id.');
    }

    $hostHash = coinpayments_array_get($invoicePayload, array('customData', 'hostHash'));
    $whmcsInvoiceId = coinpayments_array_get($invoicePayload, array('customData', 'whmcsInvoiceId'));

    if (empty($whmcsInvoiceId) && preg_match('/^WHMCS_(\d+)$/', $merchantInvoiceId, $matches)) {
        $whmcsInvoiceId = $matches[1];
    }

    if (empty($whmcsInvoiceId)) {
        $parts = explode('|', $merchantInvoiceId, 2);
        if (count($parts) === 2) {
            [$hostHash, $whmcsInvoiceId] = $parts;
        }
    }

    $gateway = new CoinPaymentsWhmcsGateway($params);
    if (empty($whmcsInvoiceId) || !is_scalar($whmcsInvoiceId)) {
        throw new RuntimeException('Webhook payload does not contain a WHMCS invoice id.');
    }

    if (empty($hostHash) || !is_string($hostHash)) {
        throw new RuntimeException('Webhook payload does not contain a WHMCS host hash.');
    }

    if (!hash_equals(md5($gateway->getSystemUrl()), $hostHash)) {
        throw new RuntimeException('Webhook invoice host hash does not match this WHMCS installation.');
    }

    $status = $payload['type'] ?? $payload['notification'] ?? $invoicePayload['status'] ?? null;
    $coinpaymentsInvoiceId = (string) ($invoicePayload['id'] ?? $payload['id'] ?? $merchantInvoiceId);
    $transactionId = $coinpaymentsInvoiceId;

    $checkedInvoiceId = checkCbInvoiceID($whmcsInvoiceId, $params['name']);

    if (coinpayments_is_cancelled_status($status)) {
        coinpayments_cancel_whmcs_invoice($checkedInvoiceId);
        logTransaction($gatewayModule, $payload, 'Cancelled');
    } elseif (coinpayments_is_paid_status($status)) {
        checkCbTransID($transactionId);

        // Trusting the WHMCS invoice amount, but applying our transaction fee to the invoice.
        $amount = coinpayments_get_whmcs_invoice_balance($checkedInvoiceId);
        $fee = coinpayments_extract_merchant_fee($invoicePayload);
        if ($amount <= 0) {
            logTransaction($gatewayModule, $payload, 'Ignored: Invoice balance already paid');
            http_response_code(200);
            exit('OK');
        }

        addInvoicePayment($checkedInvoiceId, $transactionId, $amount, $fee, $gatewayModule);
        logTransaction($gatewayModule, $payload, 'Successful');
    } else {
        logTransaction($gatewayModule, $payload, 'Ignored: ' . (string) $status);
    }

    http_response_code(200);
    exit('OK');
} catch (Throwable $exception) {
    logTransaction($gatewayModule, array('error' => $exception->getMessage(), 'body' => $rawBody), 'Webhook Error');
    http_response_code(400);
    exit('Webhook error');
}

function coinpayments_cancel_whmcs_invoice($invoiceId): void
{
    if (!function_exists('localAPI')) {
        throw new RuntimeException('WHMCS localAPI is unavailable.');
    }

    // WHMCS does not expose a separate CancelInvoice API action, changing the invoice status through UpdateInvoice is the built-in API path.
    $response = localAPI('UpdateInvoice', array(
        'invoiceid' => (int) $invoiceId,
        'status' => 'Cancelled',
    ));

    if (($response['result'] ?? '') !== 'success') {
        throw new RuntimeException('Unable to cancel WHMCS invoice: ' . ($response['message'] ?? 'unknown error'));
    }
}
