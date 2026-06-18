<?php
/**
 * CoinPayments WHMCS Gateway Bootstrap
 *
 * Loads the CoinPayments SDK and shared module dependencies.
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

use CoinPayments\CoinPaymentsClient;
use CoinPayments\Runtime\WebhookVerifier;

const COINPAYMENTS_MODULE_NAME = 'coinpayments';
const COINPAYMENTS_API_INSTANCE_URLS = array(
    'A' => 'https://a-api.coinpayments.net',
    'B' => 'https://b-api.coinpayments.net',
    'C' => 'https://c-api.coinpayments.net',
);
const COINPAYMENTS_WEBHOOK_NOTIFICATIONS = array('invoicePaid', 'invoiceCancelled');
const COINPAYMENTS_PAID_STATUSES = array('invoicepaid', 'invoicecompleted');

coinpayments_register_sdk_autoloader();

final class CoinPaymentsWhmcsGateway
{
    private array $params;
    private CoinPaymentsClient $client;

    public function __construct(array $params)
    {
        $this->params = $params;

        if (empty($params['coinpayments_client_id']) || empty($params['coinpayments_client_secret'])) {
            throw new InvalidArgumentException('CoinPayments Client ID and Client Secret are required.');
        }

        $this->client = new CoinPaymentsClient(
            $params['coinpayments_client_id'],
            $params['coinpayments_client_secret'],
            $this->getApiUrl()
        );
    }

    public function getApiUrl(): string
    {
        $instance = strtoupper((string) ($this->params['coinpayments_instance'] ?? 'A'));

        return COINPAYMENTS_API_INSTANCE_URLS[$instance] ?? COINPAYMENTS_API_INSTANCE_URLS['A'];
    }

    public function getInstance(): string
    {
        $instance = strtoupper((string) ($this->params['coinpayments_instance'] ?? 'A'));

        return array_key_exists($instance, COINPAYMENTS_API_INSTANCE_URLS) ? $instance : 'A';
    }

    public function getWhmcsInvoiceUrl(): string
    {
        return sprintf('%s/viewinvoice.php?id=%s', $this->getSystemUrl(), rawurlencode((string) $this->params['invoiceid']));
    }

    public function getSystemUrl(): string
    {
        $systemUrl = trim((string) ($this->params['systemurl'] ?? ''));

        if ($systemUrl !== '') {
            return rtrim($systemUrl, '/');
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        return $scheme . '://' . $host;
    }

    public function getWebhookUrl(): string
    {
        return $this->getSystemUrl() . '/modules/gateways/callback/coinpayments.php';
    }

    public function getOrCreateInvoice(): array
    {
        $cacheKey = $this->getSessionCacheKey();
        if (!empty($_SESSION['coinpayments']['invoices'][$cacheKey]) && is_array($_SESSION['coinpayments']['invoices'][$cacheKey])) {
            return $_SESSION['coinpayments']['invoices'][$cacheKey];
        }

        $invoice = $this->createInvoice();
        $_SESSION['coinpayments']['invoices'][$cacheKey] = $invoice;

        return $invoice;
    }

    public function createInvoice(): array
    {
        $currency = $this->getFiatCurrency((string) $this->params['currency']);
        $displayAmount = coinpayments_decimal_string($this->params['amount'] ?? '0');
        $merchantInvoiceId = $this->getMerchantInvoiceId();
        $invoiceUrl = $this->getWhmcsInvoiceUrl();
        $description = sprintf('%s invoice #%s', $this->params['companyname'] ?? 'WHMCS', $this->params['invoiceid']);

        $body = array(
            'currency' => (string) $currency['id'],
            'items' => array(
                array(
                    'customId' => (string) $this->params['invoiceid'],
                    'name' => 'Invoice #' . $this->params['invoiceid'],
                    'description' => $description,
                    'quantity' => array(
                        'value' => 1,
                        'type' => 'quantity',
                    ),
                    'amount' => $displayAmount,
                ),
            ),
            'amount' => array(
                'breakdown' => array(
                    'subtotal' => $displayAmount,
                ),
                'total' => $displayAmount,
            ),
            'isEmailDelivery' => false,
            'invoiceId' => $merchantInvoiceId,
            'description' => $description,
            'notesToRecipient' => sprintf(
                '%s/admin/orders.php?action=view&id=%s | Store name: %s | Order #%s',
                $this->getSystemUrl(),
                $this->params['invoiceid'],
                $this->params['companyname'] ?? '',
                $this->params['invoiceid']
            ),
            'metadata' => array(
                'integration' => 'plugin:whmcs_' . ($this->params['whmcsVersion'] ?? 'unknown'),
                'hostname' => $this->getSystemUrl(),
            ),
            'customData' => array(
                'integration' => 'plugin:whmcs_' . ($this->params['whmcsVersion'] ?? 'unknown'),
                'whmcsInvoiceId' => (string) $this->params['invoiceid'],
                'merchantInvoiceId' => $merchantInvoiceId,
                'hostHash' => md5($this->getSystemUrl()),
            ),
            'successUrl' => $invoiceUrl,
            'cancelUrl' => $invoiceUrl,
        );

        $buyer = coinpayments_build_buyer($this->params);
        if (!empty($buyer)) {
            $body['buyer'] = $buyer;
        }

        if (($this->params['coinpayments_webhooks'] ?? '') === 'on') {
            $body['webhooks'] = array(
                array(
                    'notificationsUrl' => $this->getWebhookUrl(),
                    'notifications' => COINPAYMENTS_WEBHOOK_NOTIFICATIONS,
                ),
            );
        }

        $response = $this->client->invoices->postMerchantInvoicesV2($body);
        $invoice = coinpayments_normalize_invoice_response($response);

        if (empty($invoice['id'])) {
            throw new RuntimeException('Unable to create CoinPayments invoice.');
        }

        $invoice['merchantInvoiceId'] = $merchantInvoiceId;
        $invoice['whmcsInvoiceId'] = (string) $this->params['invoiceid'];
        return $invoice;
    }

    public function registerWebhook(): void
    {
        $existing = $this->client->webhooks->getMerchantClientsWebhooksByIdV1($this->params['coinpayments_client_id']);
        $webhooks = coinpayments_response_items($existing);
        $webhookUrl = $this->getWebhookUrl();

        foreach ($webhooks as $webhook) {
            if (($webhook['notificationsUrl'] ?? '') === $webhookUrl) {
                return;
            }
        }

        $this->client->webhooks->postMerchantClientsWebhooksByIdV1(
            $this->params['coinpayments_client_id'],
            array(
                'notificationsUrl' => $webhookUrl,
                'notifications' => COINPAYMENTS_WEBHOOK_NOTIFICATIONS,
            )
        );
    }

    public function testConnection(): array
    {
        $response = $this->client->wallets->getMerchantWalletsV2(0, 1);
        $wallets = coinpayments_response_items($response);

        return array(
            'instance' => $this->getInstance(),
            'apiUrl' => $this->getApiUrl(),
            'walletsReturned' => count($wallets),
        );
    }

    private function getMerchantInvoiceId(): string
    {
        return 'WHMCS_' . $this->params['invoiceid'];
    }

    private function getSessionCacheKey(): string
    {
        return sha1(implode('|', array(
            $this->getSystemUrl(),
            $this->params['invoiceid'],
            $this->params['amount'],
            $this->params['currency'],
            $this->getApiUrl(),
        )));
    }

    private function getFiatCurrency(string $currencyCode): array
    {
        $response = $this->client->currencies->getCurrenciesV2($currencyCode, 'fiat');
        $items = coinpayments_response_items($response);
        $currencyCode = strtoupper($currencyCode);

        foreach ($items as $currency) {
            $candidates = array_filter(array(
                $currency['id'] ?? null,
                $currency['symbol'] ?? null,
                $currency['code'] ?? null,
                $currency['ticker'] ?? null,
            ));

            foreach ($candidates as $candidate) {
                if (strtoupper((string) $candidate) === $currencyCode) {
                    return $currency;
                }
            }
        }

        if (!empty($items[0])) {
            return $items[0];
        }

        throw new RuntimeException('Unsupported WHMCS currency for CoinPayments: ' . $currencyCode);
    }
}

function coinpayments_try_register_webhook(array $params): void
{
    try {
        (new CoinPaymentsWhmcsGateway($params))->registerWebhook();
    } catch (Throwable $exception) {
        coinpayments_log('Webhook registration failed', array('error' => $exception->getMessage()));
    }
}

function coinpayments_verify_webhook(array $params, string $rawBody, array $headers)
{
    $gateway = new CoinPaymentsWhmcsGateway($params);
    $maxAge = (int) ($params['coinpayments_webhook_max_age'] ?? 300);

    return WebhookVerifier::verify(
        'POST',
        $gateway->getWebhookUrl(),
        $rawBody,
        $headers,
        $params['coinpayments_client_secret'],
        $params['coinpayments_client_id'],
        $maxAge
    );
}

function coinpayments_register_sdk_autoloader(): void
{
    $composerAutoload = __DIR__ . '/../../../../vendor/autoload.php';
    if (is_file($composerAutoload)) {
        require_once $composerAutoload;
        if (class_exists('CoinPayments\\CoinPaymentsClient')) {
            return;
        }
    }

    spl_autoload_register(function ($class): void {
        $prefix = 'CoinPayments\\';
        if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
            return;
        }

        $relative = substr($class, strlen($prefix));
        $file = __DIR__ . '/../../../../vendor/coinpayments/src/' . str_replace('\\', '/', $relative) . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    });
}

function coinpayments_build_buyer(array $params): array
{
    $client = $params['clientdetails'] ?? array();
    if (empty($client) && isset($params['cart']->client)) {
        $client = $params['cart']->client->getAttributes();
    }

    if (empty($client)) {
        return array();
    }

    $buyer = array(
        'companyName' => (string) ($client['companyname'] ?? ''),
        'name' => array(
            'firstName' => (string) ($client['firstname'] ?? ''),
            'lastName' => (string) ($client['lastname'] ?? ''),
        ),
        'emailAddress' => (string) ($client['email'] ?? ''),
        'phoneNumber' => (string) ($client['phonenumber'] ?? ''),
    );

    $country = strtoupper((string) ($client['country'] ?? ''));

    if (
        $country !== ''
        && preg_match('/^[A-Z]{2}$/', $country)
        && !empty($client['address1'])
        && !empty($client['city'])
    ) {
        $buyer['address'] = array(
            'address1' => (string) $client['address1'],
            'provinceOrState' => (string) ($client['state'] ?? ''),
            'city' => (string) $client['city'],
            'countryCode' => $country,
            'postalCode' => (string) ($client['postcode'] ?? ''),
        );
    }

    $buyer['name'] = array_filter($buyer['name'], static fn($value) => $value !== '');
    if (empty($buyer['name'])) {
        unset($buyer['name']);
    }

    return array_filter($buyer, static fn($value) => $value !== '' && $value !== array());
}

function coinpayments_normalize_invoice_response($response): array
{
    if (!is_array($response)) {
        return array();
    }

    if (!empty($response['invoices'][0]) && is_array($response['invoices'][0])) {
        return $response['invoices'][0];
    }

    if (!empty($response['invoice']) && is_array($response['invoice'])) {
        return $response['invoice'];
    }

    if (!empty($response['data']['invoice']) && is_array($response['data']['invoice'])) {
        return $response['data']['invoice'];
    }

    return $response;
}

function coinpayments_response_items($response): array
{
    if (!is_array($response)) {
        return array();
    }

    foreach (array('items', 'data', 'webhooks', 'currencies') as $key) {
        if (!empty($response[$key]) && is_array($response[$key])) {
            return array_values($response[$key]);
        }
    }

    return array_values($response);
}

function coinpayments_decimal_string($amount): string
{
    $amount = trim((string) $amount);
    if ($amount === '') {
        return '0';
    }

    $amount = str_replace(',', '', $amount);
    if (!preg_match('/^-?\d+(\.\d+)?$/', $amount)) {
        throw new InvalidArgumentException('Invalid decimal amount: ' . $amount);
    }

    return $amount;
}

function coinpayments_escape($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function coinpayments_log(string $message, array $context = array()): void
{
    if (function_exists('logTransaction')) {
        logTransaction(COINPAYMENTS_MODULE_NAME, array('message' => $message, 'context' => $context), 'Error');
        return;
    }

    error_log($message . ' ' . json_encode($context));
}

function coinpayments_getallheaders(): array
{
    if (function_exists('getallheaders')) {
        return getallheaders();
    }

    $headers = array();
    foreach ($_SERVER as $key => $value) {
        if (strncmp($key, 'HTTP_', 5) === 0) {
            $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
            $headers[$name] = $value;
        }
    }

    return $headers;
}

function coinpayments_array_get(array $array, array $path)
{
    $value = $array;
    foreach ($path as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return null;
        }
        $value = $value[$segment];
    }

    return $value;
}

function coinpayments_extract_callback_invoice(array $payload): array
{
    foreach (array(array('invoice'), array('data', 'invoice'), array('payload', 'invoice')) as $path) {
        $invoice = coinpayments_array_get($payload, $path);
        if (is_array($invoice)) {
            return $invoice;
        }
    }

    return $payload;
}

function coinpayments_get_whmcs_invoice_balance($invoiceId): float
{
    if (!function_exists('localAPI')) {
        throw new RuntimeException('WHMCS localAPI is unavailable.');
    }

    $response = localAPI('GetInvoice', array('invoiceid' => (int) $invoiceId));
    if (($response['result'] ?? '') !== 'success') {
        throw new RuntimeException('Unable to retrieve WHMCS invoice balance: ' . ($response['message'] ?? 'unknown error'));
    }

    $balance = coinpayments_parse_decimal_amount($response['balance'] ?? null);
    if ($balance === null) {
        throw new RuntimeException('WHMCS invoice balance is missing or invalid.');
    }

    return max(0.0, $balance);
}

function coinpayments_extract_merchant_fee(array $invoicePayload): float
{
    $payments = $invoicePayload['payments'] ?? array();
    if (!is_array($payments)) {
        return 0.0;
    }

    $feeInNativeCents = 0;
    foreach ($payments as $payment) {
        if (!is_array($payment)) {
            continue;
        }

        $fees = $payment['hotWallet']['merchantFeeInNativeCurrency'] ?? array();
        if (!is_array($fees)) {
            continue;
        }

        foreach (array('coinPaymentsFee', 'networkFee', 'conversionFee') as $feeKey) {
            $feeInNativeCents += (int) ($fees[$feeKey] ?? 0);
        }
    }

    return round($feeInNativeCents / 100, 2);
}

function coinpayments_parse_decimal_amount($value): ?float
{
    if ($value === null || $value === '') {
        return null;
    }

    $value = str_replace(',', '', trim((string) $value));
    if (!is_numeric($value)) {
        return null;
    }

    return (float) $value;
}

function coinpayments_is_paid_status(?string $status): bool
{
    return in_array(strtolower(trim((string) $status)), COINPAYMENTS_PAID_STATUSES, true);
}
