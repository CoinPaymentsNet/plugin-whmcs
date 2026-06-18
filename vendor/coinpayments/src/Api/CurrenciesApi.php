<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class CurrenciesApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * lists platform supported currencies and their capabilities. - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesV1
     * @param mixed $q optional search query to find currencies with names and/or codes similar to the specified search string
     * @param mixed $types comma separated list of the types of currencies to return (e.g. 'coin', 'token', 'fiat', etc.).  By default currencies of all types are returned
     * @param mixed $capabilities comma separated list of capabilities, currencies without the specified capabilities won't be returned
     */
    public function getCurrenciesV1(mixed $q = null, mixed $types = null, mixed $capabilities = null): mixed
    {
        return $this->http->call("GET", "/api/v1/currencies", ["query" => ["q" => $q, "types" => $types, "capabilities" => $capabilities], "authed" => false]);
    }


    /**
     * lists platform supported currencies and their capabilities. - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesV2
     * @param mixed $q optional search query to find currencies with names and/or codes similar to the specified search string
     * @param mixed $types comma separated list of the types of currencies to return (e.g. 'coin', 'token', 'fiat', etc.).  By default currencies of all types are returned
     * @param mixed $capabilities comma separated list of capabilities, currencies without the specified capabilities won't be returned
     */
    public function getCurrenciesV2(mixed $q = null, mixed $types = null, mixed $capabilities = null): mixed
    {
        return $this->http->call("GET", "/api/v2/currencies", ["query" => ["q" => $q, "types" => $types, "capabilities" => $capabilities], "authed" => false]);
    }


    /**
     * finds a currency by its id - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesByIdV1
     * @param mixed $id the id of the currency to retrieve
     */
    public function getCurrenciesByIdV1(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v1/currencies/:id", ["pathParams" => ["id" => $id], "authed" => false]);
    }


    /**
     * finds a currency by its id - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesByIdV2
     * @param mixed $id the id of the currency to retrieve
     */
    public function getCurrenciesByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/currencies/:id", ["pathParams" => ["id" => $id], "authed" => false]);
    }


    /**
     * Gets the merchant's currently accepted currencies.
Currencies that are ranked (ordered) will be returned at the top of the list. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/currencies/routes/getMerchantCurrenciesV1
     */
    public function getMerchantCurrenciesV1(): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/currencies", ["authed" => true]);
    }


    /**
     * Gets the latest blockchain block number by currency - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesBlockchainNodesLatestBlockNumberByIdV1
     * @param mixed $id ID of the currency.
     */
    public function getCurrenciesBlockchainNodesLatestBlockNumberByIdV1(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v1/currencies/blockchain-nodes/:id/latest-block-number", ["pathParams" => ["id" => $id], "authed" => false]);
    }


    /**
     * Gets the latest blockchain block number by currency - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesBlockchainNodesLatestBlockNumberByIdV2
     * @param mixed $id ID of the currency.
     */
    public function getCurrenciesBlockchainNodesLatestBlockNumberByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/currencies/blockchain-nodes/:id/latest-block-number", ["pathParams" => ["id" => $id], "authed" => false]);
    }


    /**
     * Gets the required confirmations for each currency - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesRequiredConfirmationsV1
     */
    public function getCurrenciesRequiredConfirmationsV1(): mixed
    {
        return $this->http->call("GET", "/api/v1/currencies/required-confirmations", ["authed" => false]);
    }


    /**
     * Gets the required confirmations for each currency - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesRequiredConfirmationsV2
     */
    public function getCurrenciesRequiredConfirmationsV2(): mixed
    {
        return $this->http->call("GET", "/api/v2/currencies/required-confirmations", ["authed" => false]);
    }


    /**
     * gets a list of all possible currency conversions - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesConversionsV1
     */
    public function getCurrenciesConversionsV1(): mixed
    {
        return $this->http->call("GET", "/api/v1/currencies/conversions", ["authed" => false]);
    }


    /**
     * gets a list of all possible currency conversions - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesConversionsV2
     */
    public function getCurrenciesConversionsV2(): mixed
    {
        return $this->http->call("GET", "/api/v2/currencies/conversions", ["authed" => false]);
    }


    /**
     * Returns conversion limits by currency pair - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesLimitsByFromToV1
     * @param mixed $from From currency in format `1` or `4:0xdac17f958d2ee523a2206206994597c13d831ec7` for smart contracts
     * @param mixed $to To currency in format `1` or `4:0xdac17f958d2ee523a2206206994597c13d831ec7` for smart contracts
     */
    public function getCurrenciesLimitsByFromToV1(mixed $from, mixed $to): mixed
    {
        return $this->http->call("GET", "/api/v1/currencies/limits/:from/:to", ["pathParams" => ["from" => $from, "to" => $to], "authed" => false]);
    }


    /**
     * Returns conversion limits by currency pair - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/currencies/routes/getCurrenciesLimitsByFromToV2
     * @param mixed $from From currency in format `1` or `4:0xdac17f958d2ee523a2206206994597c13d831ec7` for smart contracts
     * @param mixed $to To currency in format `1` or `4:0xdac17f958d2ee523a2206206994597c13d831ec7` for smart contracts
     */
    public function getCurrenciesLimitsByFromToV2(mixed $from, mixed $to): mixed
    {
        return $this->http->call("GET", "/api/v2/currencies/limits/:from/:to", ["pathParams" => ["from" => $from, "to" => $to], "authed" => false]);
    }
}
