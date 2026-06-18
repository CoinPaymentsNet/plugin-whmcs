<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments;

use CoinPayments\Runtime\HttpClient;
use CoinPayments\Api\AccessControlApi;
use CoinPayments\Api\CurrenciesApi;
use CoinPayments\Api\FeesApi;
use CoinPayments\Api\InvoicesApi;
use CoinPayments\Api\RatesApi;
use CoinPayments\Api\TransactionsApi;
use CoinPayments\Api\WalletsApi;
use CoinPayments\Api\WebhooksApi;

final class CoinPaymentsClient
{
    private HttpClient $http;
    public readonly AccessControlApi $accessControl;
    public readonly CurrenciesApi $currencies;
    public readonly FeesApi $fees;
    public readonly InvoicesApi $invoices;
    public readonly RatesApi $rates;
    public readonly TransactionsApi $transactions;
    public readonly WalletsApi $wallets;
    public readonly WebhooksApi $webhooks;

    public function __construct(
        ?string $clientId = null,
        ?string $clientSecret = null,
        string $baseUrl = "https://a-api.coinpayments.net",
    ) {
        $this->http = new HttpClient($baseUrl, $clientId, $clientSecret);
        $this->accessControl = new AccessControlApi($this->http);
        $this->currencies = new CurrenciesApi($this->http);
        $this->fees = new FeesApi($this->http);
        $this->invoices = new InvoicesApi($this->http);
        $this->rates = new RatesApi($this->http);
        $this->transactions = new TransactionsApi($this->http);
        $this->wallets = new WalletsApi($this->http);
        $this->webhooks = new WebhooksApi($this->http);
    }
}
