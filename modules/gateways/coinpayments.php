<?php
/**
 * CoinPayments WHMCS Gateway
 *
 * SDK-based CoinPayments payment gateway module for WHMCS.
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

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

require_once __DIR__ . '/coinpayments/lib/api.php';

function coinpayments_config($params = array())
{
    $config = array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'CoinPayments',
        ),
        'coinpayments_client_id' => array(
            'FriendlyName' => 'Client ID',
            'Type' => 'text',
            'Size' => '48',
            'Description' => 'Your CoinPayments API client ID.' . coinpayments_onboarding_markup(),
        ),
        'coinpayments_client_secret' => array(
            'FriendlyName' => 'Client Secret',
            'Type' => 'password',
            'Size' => '48',
            'Description' => 'Your CoinPayments API client secret.',
        ),
        'coinpayments_instance' => array(
            'FriendlyName' => 'Instance',
            'Type' => 'dropdown',
            'Options' => 'A,B,C',
            'Default' => 'A',
            'Description' => 'Select the CoinPayments API instance assigned to this merchant account.' . coinpayments_test_connection_markup(),
        ),
        'coinpayments_webhooks' => array(
            'FriendlyName' => 'Enable Webhooks',
            'Type' => 'yesno',
            'Description' => 'Recommended. Lets CoinPayments mark WHMCS invoices paid automatically.',
        ),
        'coinpayments_auto_register_webhook' => array(
            'FriendlyName' => 'Auto-register Webhook',
            'Type' => 'yesno',
            'Description' => 'Creates the CoinPayments webhook after the Client ID and Client Secret are saved.',
        ),
        'coinpayments_webhook_max_age' => array(
            'FriendlyName' => 'Webhook Max Age',
            'Type' => 'text',
            'Size' => '6',
            'Default' => '300',
            'Description' => 'Seconds of allowed signature timestamp drift. Use 0 only for local testing.',
        ),
    );

    if (
        isset($params['coinpayments_webhooks'], $params['coinpayments_auto_register_webhook'])
        && $params['coinpayments_webhooks'] === 'on'
        && $params['coinpayments_auto_register_webhook'] === 'on'
        && !empty($params['coinpayments_client_id'])
        && !empty($params['coinpayments_client_secret'])
    ) {
        coinpayments_try_register_webhook($params);
    }

    return $config;
}

function coinpayments_link($params)
{
    try {
        $gateway = new CoinPaymentsWhmcsGateway($params);
        $invoice = $gateway->getOrCreateInvoice();

        if (empty($invoice['id'])) {
            throw new RuntimeException('CoinPayments did not return an invoice id.');
        }

        if (empty($invoice['checkoutLink'])) {
            throw new RuntimeException('CoinPayments did not return a checkout link.');
        }

        $coinpaymentsInvoiceId = coinpayments_escape($invoice['id']);
        $merchantInvoiceId = coinpayments_escape($invoice['merchantInvoiceId'] ?? '');

        return '<div>'
            . '<a href="' . coinpayments_escape($invoice['checkoutLink']) . '" target="_blank" rel="noopener noreferrer" style="display:inline-block;background:#387EFF;border:1px solid #030406;border-radius:4px;color:#FFFFFF;font-size:15px;font-weight:700;line-height:1;padding:12px 18px;text-decoration:none;">Pay with CoinPayments</a>'
            . '<div style="color:#52616f;font-size:12px;line-height:1.5;margin-top:8px;">CoinPayments Invoice ID: <code>' . $coinpaymentsInvoiceId . '</code></div>'
            . ($merchantInvoiceId !== '' ? '<div style="color:#52616f;font-size:12px;line-height:1.5;">External Invoice ID: <code>' . $merchantInvoiceId . '</code></div>' : '')
            . '</div>';
    } catch (Throwable $exception) {
        coinpayments_log('Invoice creation failed', array(
            'invoiceId' => $params['invoiceid'] ?? null,
            'error' => $exception->getMessage(),
            'payload' => property_exists($exception, 'payload') ? $exception->payload : null,
        ));

        return '<div class="alert alert-danger">CoinPayments is temporarily unavailable. Please contact support or try again later.</div>';
    }
}

function coinpayments_test_connection_markup()
{
    $endpoint = '../modules/gateways/coinpayments/test_connection.php';

    return <<<HTML
<div style="margin-top:8px;">
    <button type="button" id="coinpayments-test-connection" class="btn btn-default btn-sm">Test Connection</button>
    <span id="coinpayments-test-connection-result" style="display:inline-block;margin-left:8px;"></span>
    <div style="margin-top:4px;color:#666;">Save changes first. The test calls the saved instance's get wallets route.</div>
</div>
<script>
(function () {
    var button = document.getElementById('coinpayments-test-connection');
    var result = document.getElementById('coinpayments-test-connection-result');
    if (!button || !result) {
        return;
    }

    button.addEventListener('click', function () {
        button.disabled = true;
        result.style.color = '#666';
        result.textContent = 'Testing...';

        fetch('$endpoint', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {'Accept': 'application/json'}
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    return {ok: response.ok, data: data};
                });
            })
            .then(function (response) {
                if (!response.ok || !response.data.ok) {
                    throw new Error(response.data.message || 'Connection test failed.');
                }

                result.style.color = '#3c763d';
                result.textContent = response.data.message;
            })
            .catch(function (error) {
                result.style.color = '#a94442';
                result.textContent = error.message;
            })
            .finally(function () {
                button.disabled = false;
            });
    });
})();
</script>
HTML;
}

function coinpayments_onboarding_markup()
{
    return <<<HTML
<div style="border:1px solid #d9e2ec;border-radius:6px;background:#f8fafc;margin-top:12px;max-width:820px;padding:14px 16px;">
    <div style="font-weight:700;margin-bottom:8px;">New to CoinPayments? Start here.</div>
    <ol style="margin:0 0 10px 18px;padding:0;">
        <li style="margin-bottom:6px;">
            <strong>Create an account.</strong>
            Register for CoinPayments, confirm your email, and enable 2FA.
            <a href="https://www.coinpayments.net/register" target="_blank" rel="noopener noreferrer">Create account</a>
            ·
            <a href="https://docs.coinpayments.net/knowledge/integration-guide/account-setup/" target="_blank" rel="noopener noreferrer">Account setup guide</a>
        </li>
        <li style="margin-bottom:6px;">
            <strong>Complete compliance verification.</strong>
            Business verification is required before commercial tools such as invoicing, API integrations, and eCommerce plugins are available.
            <a href="https://docs.coinpayments.net/knowledge/integration-guide/account-setup/" target="_blank" rel="noopener noreferrer">Verification requirements</a>
        </li>
        <li style="margin-bottom:6px;">
            <strong>Create an API integration.</strong>
            In the CoinPayments dashboard, add an API integration, copy the Client ID and Client Secret, then paste them into these settings.
            <a href="https://docs.coinpayments.net/api/auth/create-integration/" target="_blank" rel="noopener noreferrer">Create integration/API keys guide</a>
        </li>
        <li style="margin-bottom:6px;">
            <strong>Select the correct instance.</strong>
            Choose A, B, or C according to your business registration country, then save and use Test Connection.
            <a href="https://docs.coinpayments.net/instances/" target="_blank" rel="noopener noreferrer">Find your instance</a>
        </li>
        <li style="margin-bottom:6px;">
            <strong>Test payment reconciliation.</strong>
            Place a small test order, pay from the hosted checkout, confirm WHMCS marks the invoice paid, then compare the WHMCS transaction ID with CoinPayments invoice status and webhook logs.
            <a href="https://docs.coinpayments.net/api/webhooks/" target="_blank" rel="noopener noreferrer">Webhooks guide</a>
            ·
            <a href="https://docs.coinpayments.net/api/invoices/routes/getInvoicesPaymentCurrenciesStatusByIdCurrencyV1/" target="_blank" rel="noopener noreferrer">Invoice status route</a>
        </li>
        <li>
            <strong>Disable testing currency (LTCT).</strong>
            Disable the testing currency, and prepare to begin accepting crypto payments!
            <a href="https://docs.coinpayments.net/api/invoices/payment-settings/" target="_blank" rel="noopener noreferrer">Payment settings</a>
            ·
            <a href="https://docs.coinpayments.net/knowledge/integration-guide/testing-integrations#disable-litecoin-testnet-payments" target="_blank" rel="noopener noreferrer">Disabling guide</a>
        </li>
    </ol>
    <div style="color:#52616f;">
        Tip: save settings before clicking Test Connection. The button validates saved API credentials and instance routing with the get wallets route.
    </div>
</div>
HTML;
}
