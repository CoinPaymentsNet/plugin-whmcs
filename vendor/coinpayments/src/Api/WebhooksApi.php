<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class WebhooksApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * Updates the webhook configuration for a specific wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantWalletsWebhookByIdV1
     * @param mixed $id the id of the wallet to update the webhook for
     * @param array $body UpdateWalletWebhookRequestDto
     */
    public function putMerchantWalletsWebhookByIdV1(mixed $id, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v1/merchant/wallets/:id/webhook", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Updates the webhook configuration for a specific wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantWalletsWebhookByIdV2
     * @param mixed $id the id of the wallet to update the webhook for
     * @param array $body UpdateWalletWebhookRequestDto
     */
    public function putMerchantWalletsWebhookByIdV2(mixed $id, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v2/merchant/wallets/:id/webhook", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Updates the webhook configuration for a specific wallet address - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantWalletsAddressesWebhookByIdAIdV1
     * @param mixed $id the id of the wallet containing the address
     * @param mixed $aId the id of the address to update the webhook for
     * @param array $body UpdateWalletWebhookRequestDto
     */
    public function putMerchantWalletsAddressesWebhookByIdAIdV1(mixed $id, mixed $aId, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v1/merchant/wallets/:id/addresses/:aId/webhook", ["pathParams" => ["id" => $id, "aId" => $aId], "body" => $body, "authed" => true]);
    }


    /**
     * Updates the webhook configuration for a specific wallet address - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantWalletsAddressesWebhookByIdAIdV2
     * @param mixed $id the id of the wallet containing the address
     * @param mixed $aId the id of the address to update the webhook for
     * @param array $body UpdateWalletWebhookRequestDto
     */
    public function putMerchantWalletsAddressesWebhookByIdAIdV2(mixed $id, mixed $aId, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v2/merchant/wallets/:id/addresses/:aId/webhook", ["pathParams" => ["id" => $id, "aId" => $aId], "body" => $body, "authed" => true]);
    }


    /**
     * Create a new webhook for a client - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/postMerchantClientsWebhooksByIdV1
     * @param mixed $id The public ID of a client
     * @param array $body CreateMerchantClientWebhookRequestDto
     */
    public function postMerchantClientsWebhooksByIdV1(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/clients/:id/webhooks", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * List all of the webhooks for a particular client - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/getMerchantClientsWebhooksByIdV1
     * @param mixed $id Target `ClientId`
     * @param mixed $type Notification type. Null for all
     */
    public function getMerchantClientsWebhooksByIdV1(mixed $id, mixed $type = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/clients/:id/webhooks", ["pathParams" => ["id" => $id], "query" => ["type" => $type], "authed" => true]);
    }


    /**
     * Update an existing webhook for a client - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantClientsWebhooksByIdWIdV1
     * @param mixed $id The public ID of a client
     * @param mixed $wId the ID of the webhook to update
     * @param array $body UpdateMerchantClientWebhookDto
     */
    public function putMerchantClientsWebhooksByIdWIdV1(mixed $id, mixed $wId, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v1/merchant/clients/:id/webhooks/:wId", ["pathParams" => ["id" => $id, "wId" => $wId], "body" => $body, "authed" => true]);
    }


    /**
     * Delete a webhook for a client - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/deleteMerchantClientsWebhooksByIdWIdV1
     * @param mixed $id the public ID of a client
     * @param mixed $wId the ID of the webhook to delete
     */
    public function deleteMerchantClientsWebhooksByIdWIdV1(mixed $id, mixed $wId): mixed
    {
        return $this->http->call("DELETE", "/api/v1/merchant/clients/:id/webhooks/:wId", ["pathParams" => ["id" => $id, "wId" => $wId], "authed" => true]);
    }


    /**
     * Updates the webhook configuration for a specific wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantWalletsWebhookByLabelCurrencyV3
     * @param mixed $label the unique id for the wallet provided by client
     * @param mixed $currency the currency of the wallet to update webhook for
     * @param array $body UpdateWalletWebhookRequestDto
     */
    public function putMerchantWalletsWebhookByLabelCurrencyV3(mixed $label, mixed $currency, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v3/merchant/wallets/:label/:currency/webhook", ["pathParams" => ["label" => $label, "currency" => $currency], "body" => $body, "authed" => true]);
    }


    /**
     * Updates the webhook configuration for a specific wallet address - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/webhooks/routes/putMerchantWalletsAddressesWebhookByWLabelCurrencyALabelV3
     * @param mixed $wLabel the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet containing the address
     * @param mixed $aLabel the unique label for the address provided by client
     * @param array $body UpdateWalletWebhookRequestDto
     */
    public function putMerchantWalletsAddressesWebhookByWLabelCurrencyALabelV3(mixed $wLabel, mixed $currency, mixed $aLabel, array $body): mixed
    {
        return $this->http->call("PUT", "/api/v3/merchant/wallets/:wLabel/:currency/addresses/:aLabel/webhook", ["pathParams" => ["wLabel" => $wLabel, "currency" => $currency, "aLabel" => $aLabel], "body" => $body, "authed" => true]);
    }
}
