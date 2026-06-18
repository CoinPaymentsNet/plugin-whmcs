<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class FeesApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * Returns the current blockchain fee for sending funds from the CoinPayments system to an external address - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/fees/routes/getFeesBlockchainByIdV1
     * @param mixed $id Currency in format `1` or `4:0xdac17f958d2ee523a2206206994597c13d831ec7` for smart contracts
     */
    public function getFeesBlockchainByIdV1(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v1/fees/blockchain/:id", ["pathParams" => ["id" => $id], "authed" => false]);
    }


    /**
     * Returns the current blockchain fee for sending funds from the CoinPayments system to an external address - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/fees/routes/getFeesBlockchainByIdV2
     * @param mixed $id Currency in format `1` or `4:0xdac17f958d2ee523a2206206994597c13d831ec7` for smart contracts
     */
    public function getFeesBlockchainByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/fees/blockchain/:id", ["pathParams" => ["id" => $id], "authed" => false]);
    }
}
