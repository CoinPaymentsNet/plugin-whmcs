<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class AccessControlApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * Allows merchant clients to downgrade their access scope by reducing permissions - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/accessControl/routes/postMerchantClientsAccessControlV1
     * @param array $body UpdateMerchantClientAccessControlDto
     */
    public function postMerchantClientsAccessControlV1(array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/clients/access-control", ["body" => $body, "authed" => true]);
    }


    /**
     * Retrieves the current allowed access control scope for the authenticated merchant client - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/accessControl/routes/getMerchantClientsAccessControlV1
     */
    public function getMerchantClientsAccessControlV1(): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/clients/access-control", ["authed" => true]);
    }
}
