<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class RatesApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * lists the current conversion rates between currencies - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/rates/routes/getRatesV1
     * @param mixed $from comma separated list of currencies to use as the source for rate calculations. The allowed input format is {currencyId}:{contractAddress}
     * @param mixed $to comma separated list of currencies for which to retrieve conversion rates for (from the `from` currencies). The allowed input format is {currencyId}:{contractAddress}
     * @param mixed $pointInTime Point in time for which to get rate, if null the latest rate is returned
     */
    public function getRatesV1(mixed $from = null, mixed $to = null, mixed $pointInTime = null): mixed
    {
        return $this->http->call("GET", "/api/v1/rates", ["query" => ["from" => $from, "to" => $to, "pointInTime" => $pointInTime], "authed" => false]);
    }


    /**
     * lists the current conversion rates between currencies - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/rates/routes/getRatesV2
     * @param mixed $from comma separated list of currencies to use as the source for rate calculations. The allowed input format is {currencyId}:{contractAddress}
     * @param mixed $to comma separated list of currencies for which to retrieve conversion rates for (from the `from` currencies). The allowed input format is {currencyId}:{contractAddress}
     * @param mixed $pointInTime Point in time for which to get rate, if null the latest rate is returned
     */
    public function getRatesV2(mixed $from = null, mixed $to = null, mixed $pointInTime = null): mixed
    {
        return $this->http->call("GET", "/api/v2/rates", ["query" => ["from" => $from, "to" => $to, "pointInTime" => $pointInTime], "authed" => false]);
    }
}
