<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class WalletsApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * Creates a new merchant wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/postMerchantWalletsV1
     * @param array $body NewWalletRequestDto
     */
    public function postMerchantWalletsV1(array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets", ["body" => $body, "authed" => true]);
    }


    /**
     * Creates a new merchant wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/postMerchantWalletsV2
     * @param array $body NewWalletRequestV2Dto
     */
    public function postMerchantWalletsV2(array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets", ["body" => $body, "authed" => true]);
    }


    /**
     * Lists merchant client wallets (up to 100 wallets per response) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsV1
     * @param mixed $skip How may transaction to skip (used for paging)
     * @param mixed $take How may transaction to take (used for paging)
     */
    public function getMerchantWalletsV1(mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets", ["query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Lists merchant client wallets (up to 100 wallets per response) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsV2
     * @param mixed $skip how many wallets to skip (used for paging)
     * @param mixed $take how many wallets to take (used for paging)
     */
    public function getMerchantWalletsV2(mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets", ["query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Finds a merchant client wallet by id - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsByIdV1
     * @param mixed $id the id of the wallet
     */
    public function getMerchantWalletsByIdV1(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Finds a merchant client wallet by id - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsByIdV2
     * @param mixed $id the id of the wallet
     */
    public function getMerchantWalletsByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Creates an address under a wallet by the wallet ID - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/postMerchantWalletsAddressesByIdV1
     * @param mixed $id the ID of the wallet to create the address under
     * @param array $body CreateMerchantWalletAddressRequestDto
     */
    public function postMerchantWalletsAddressesByIdV1(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets/:id/addresses", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Creates an address under a wallet by the wallet ID - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/postMerchantWalletsAddressesByIdV2
     * @param mixed $id the id of the wallet to create the address under
     * @param array $body CreateMerchantWalletAddressRequestDto
     */
    public function postMerchantWalletsAddressesByIdV2(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets/:id/addresses", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Lists all merchant addresses of a specific wallet by the wallet Id - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesByIdV1
     * @param mixed $id the id of the wallet
     * @param mixed $skip how many addresses to skip (used for paging)
     * @param mixed $take how many addresses to take (used for paging)
     */
    public function getMerchantWalletsAddressesByIdV1(mixed $id, mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/addresses", ["pathParams" => ["id" => $id], "query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Lists all merchant addresses of a specific wallet by the wallet Id - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesByIdV2
     * @param mixed $id the id of the wallet
     * @param mixed $skip how many addresses to skip (used for paging)
     * @param mixed $take how many addresses to take (used for paging)
     */
    public function getMerchantWalletsAddressesByIdV2(mixed $id, mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/addresses", ["pathParams" => ["id" => $id], "query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Get a specific address by its Id and the Id of the wallet it belongs to - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesByIdAIdV1
     * @param mixed $id the id of the wallet containing the address
     * @param mixed $aId the id of the address to retrieve
     */
    public function getMerchantWalletsAddressesByIdAIdV1(mixed $id, mixed $aId): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/addresses/:aId", ["pathParams" => ["id" => $id, "aId" => $aId], "authed" => true]);
    }


    /**
     * Get a specific address by its Id and the Id of the wallet it belongs to - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesByIdAIdV2
     * @param mixed $id the id of the wallet containing the address
     * @param mixed $aId the id of the address to retrieve
     */
    public function getMerchantWalletsAddressesByIdAIdV2(mixed $id, mixed $aId): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/addresses/:aId", ["pathParams" => ["id" => $id, "aId" => $aId], "authed" => true]);
    }


    /**
     * Get merchant client wallets count - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsCountV2
     */
    public function getMerchantWalletsCountV2(): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/count", ["authed" => true]);
    }


    /**
     * Get merchant addresses count of a specific wallet by the wallet Id - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesCountByIdV2
     * @param mixed $id the id of the wallet
     */
    public function getMerchantWalletsAddressesCountByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/addresses/count", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Returns the wallet balance in a specific date time offset - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsBalanceByIdDateV1
     * @param mixed $id the wallet id
     * @param mixed $date the specific date time offset to retrieve what the wallet balance was at that time
     */
    public function getMerchantWalletsBalanceByIdDateV1(mixed $id, mixed $date): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/balance/:date", ["pathParams" => ["id" => $id, "date" => $date], "authed" => true]);
    }


    /**
     * Returns the wallet balance in a specific date time offset - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsBalanceByIdDateV2
     * @param mixed $id the wallet id
     * @param mixed $date the specific date time offset to retrieve what the wallet balance was at that time
     */
    public function getMerchantWalletsBalanceByIdDateV2(mixed $id, mixed $date): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/balance/:date", ["pathParams" => ["id" => $id, "date" => $date], "authed" => true]);
    }


    /**
     * Lists merchant client wallets (up to 100 wallets per response) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsV3
     * @param mixed $skip how many wallets to skip (used for paging)
     * @param mixed $take how many wallets to take (used for paging)
     */
    public function getMerchantWalletsV3(mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets", ["query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Creates or retrieves a wallet and address by external Ids - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/putMerchantWalletsV3
     * @param array $body NewWalletAndAddressRequestV3Dto
     */
    public function putMerchantWalletsV3(array $body): mixed
    {
        return $this->http->call("PUT", "/api/v3/merchant/wallets", ["body" => $body, "authed" => true]);
    }


    /**
     * Get merchant client wallets count - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsCountV3
     */
    public function getMerchantWalletsCountV3(): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/count", ["authed" => true]);
    }


    /**
     * Get merchant addresses count of a specific wallet by the wallet label - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesCountByLabelCurrencyV3
     * @param mixed $label the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet
     */
    public function getMerchantWalletsAddressesCountByLabelCurrencyV3(mixed $label, mixed $currency): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/addresses/count", ["pathParams" => ["label" => $label, "currency" => $currency], "authed" => true]);
    }


    /**
     * Lists all merchant addresses of a specific wallet by unique wallet label and currency Id - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesByLabelCurrencyV3
     * @param mixed $label the unique id for the wallet provided by client
     * @param mixed $currency the currency of the wallet to list addresses for
     * @param mixed $skip How many addresses to skip (used for paging)
     * @param mixed $take How many addresses to take (used for paging)
     */
    public function getMerchantWalletsAddressesByLabelCurrencyV3(mixed $label, mixed $currency, mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/addresses", ["pathParams" => ["label" => $label, "currency" => $currency], "query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Get a specific address by its label and the label of the wallet it belongs to - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/wallets/routes/getMerchantWalletsAddressesByWLabelCurrencyALabelV3
     * @param mixed $wLabel the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet containing the address
     * @param mixed $aLabel the unique label for the address provided by client
     */
    public function getMerchantWalletsAddressesByWLabelCurrencyALabelV3(mixed $wLabel, mixed $currency, mixed $aLabel): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:wLabel/:currency/addresses/:aLabel", ["pathParams" => ["wLabel" => $wLabel, "currency" => $currency, "aLabel" => $aLabel], "authed" => true]);
    }
}
