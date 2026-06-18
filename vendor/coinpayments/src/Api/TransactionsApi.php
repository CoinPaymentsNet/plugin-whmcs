<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class TransactionsApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * Lists transactions used for consolidating funds to pay fee for the withdrawal - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsConsolidationTransactionsByIdSpendIdV1
     * @param mixed $id the id of the wallet
     * @param mixed $spendId ID of the withdrawal (spend request)
     */
    public function getMerchantWalletsConsolidationTransactionsByIdSpendIdV1(mixed $id, mixed $spendId): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/consolidation-transactions/:spendId", ["pathParams" => ["id" => $id, "spendId" => $spendId], "authed" => true]);
    }


    /**
     * Lists transactions used for consolidating funds to pay fee for the withdrawal - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsConsolidationTransactionsByIdSpendIdV2
     * @param mixed $id the id of the wallet
     * @param mixed $spendId ID of the withdrawal (spend request)
     */
    public function getMerchantWalletsConsolidationTransactionsByIdSpendIdV2(mixed $id, mixed $spendId): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/consolidation-transactions/:spendId", ["pathParams" => ["id" => $id, "spendId" => $spendId], "authed" => true]);
    }


    /**
     * Lists transactions of the wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionsByIdV1
     * @param mixed $id the id of the wallet
     * @param mixed $skip how many transactions to skip (used for paging)
     * @param mixed $take how many transactions to take (used for paging)
     */
    public function getMerchantWalletsTransactionsByIdV1(mixed $id, mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/transactions", ["pathParams" => ["id" => $id], "query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Lists transactions of the wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionsByIdV2
     * @param mixed $id the id of the wallet
     * @param mixed $skip how many transactions to skip (used for paging)
     * @param mixed $take how many transactions to take (used for paging)
     */
    public function getMerchantWalletsTransactionsByIdV2(mixed $id, mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/transactions", ["pathParams" => ["id" => $id], "query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Get a specific transaction of the wallet, if transactionId is specified for search then the spendRequestId is ignored otherwise a first spending transaction with matching spendRequestId is returned - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionByIdV1
     * @param mixed $id the id of the wallet
     * @param mixed $transactionId Id of the transaction to look for
     * @param mixed $spendRequestId SpendRequestId of the transaction to look for
     */
    public function getMerchantWalletsTransactionByIdV1(mixed $id, mixed $transactionId = null, mixed $spendRequestId = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/transaction", ["pathParams" => ["id" => $id], "query" => ["transactionId" => $transactionId, "spendRequestId" => $spendRequestId], "authed" => true]);
    }


    /**
     * Get a specific transaction of the wallet, if transactionId is specified for search then the spendRequestId is ignored otherwise a first spending transaction with matching spendRequestId is returned - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionByIdV2
     * @param mixed $id the id of the wallet
     * @param mixed $transactionId Id of the transaction to look for
     * @param mixed $spendRequestId SpendRequestId of the transaction to look for
     */
    public function getMerchantWalletsTransactionByIdV2(mixed $id, mixed $transactionId = null, mixed $spendRequestId = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/transaction", ["pathParams" => ["id" => $id], "query" => ["transactionId" => $transactionId, "spendRequestId" => $spendRequestId], "authed" => true]);
    }


    /**
     * Executes merchant wallet consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationByIdToV1
     * @param mixed $id the id of the wallet which will be sending funds
     * @param mixed $to the id of the wallet which will be receiving funds
     * @param mixed $addressIds Comma-separated IDs of addresses for consolidation
     */
    public function postMerchantWalletsConsolidationByIdToV1(mixed $id, mixed $to, mixed $addressIds = null): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets/:id/consolidation/:to", ["pathParams" => ["id" => $id, "to" => $to], "query" => ["addressIds" => $addressIds], "authed" => true]);
    }


    /**
     * Executes merchant wallet consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationByIdToV2
     * @param mixed $id the id of the wallet which will be sending funds
     * @param mixed $to the id of the wallet which will be receiving funds
     * @param mixed $addressIds Comma-separated IDs of addresses for consolidation
     */
    public function postMerchantWalletsConsolidationByIdToV2(mixed $id, mixed $to, mixed $addressIds = null): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets/:id/consolidation/:to", ["pathParams" => ["id" => $id, "to" => $to], "query" => ["addressIds" => $addressIds], "authed" => true]);
    }


    /**
     * Returns info about merchant wallet consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsConsolidationByIdV1
     * @param mixed $id the id of the wallet which will be sending funds to the main wallet
     * @param mixed $addressIds Comma-separated IDs of addresses for consolidation
     */
    public function getMerchantWalletsConsolidationByIdV1(mixed $id, mixed $addressIds = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/wallets/:id/consolidation", ["pathParams" => ["id" => $id], "query" => ["addressIds" => $addressIds], "authed" => true]);
    }


    /**
     * Returns info about merchant wallet consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsConsolidationByIdV2
     * @param mixed $id the id of the wallet which will be sending funds to the main wallet
     * @param mixed $addressIds Comma-separated IDs of addresses for consolidation
     */
    public function getMerchantWalletsConsolidationByIdV2(mixed $id, mixed $addressIds = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/consolidation", ["pathParams" => ["id" => $id], "query" => ["addressIds" => $addressIds], "authed" => true]);
    }


    /**
     * Preview merchant wallets consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationPreviewV1
     * @param array $body WalletsConsolidationRequestDto
     */
    public function postMerchantWalletsConsolidationPreviewV1(array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets/consolidation-preview", ["body" => $body, "authed" => true]);
    }


    /**
     * Preview merchant wallets consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationPreviewV2
     * @param array $body WalletsConsolidationRequestDto
     */
    public function postMerchantWalletsConsolidationPreviewV2(array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets/consolidation-preview", ["body" => $body, "authed" => true]);
    }


    /**
     * Execute merchant wallets consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationByIdV1
     * @param mixed $id the id of the wallet which will be receiving funds
     * @param array $body WalletsConsolidationRequestDto
     */
    public function postMerchantWalletsConsolidationByIdV1(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets/consolidation/:id", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Execute merchant wallets consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationByIdV2
     * @param mixed $id the ID of the wallet which will be receiving funds (optional)
     * @param array $body WalletsConsolidationRequestDto
     */
    public function postMerchantWalletsConsolidationByIdV2(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets/consolidation/:id", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Sends a request to spend funds from the merchant client wallet. Also used to convert funds between supported cryptocurrencies - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsSpendRequestByIdV1
     * @param mixed $id the id of the wallet from which to spend funds from
     * @param array $body SpendRequestDto
     */
    public function postMerchantWalletsSpendRequestByIdV1(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets/:id/spend/request", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Sends a request to spend funds from the merchant client wallet. Also used to convert funds between supported cryptocurrencies - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsSpendRequestByIdV2
     * @param mixed $id the id of the wallet from which to spend funds from
     * @param array $body SpendRequestV2Dto
     */
    public function postMerchantWalletsSpendRequestByIdV2(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets/:id/spend/request", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Sends a request to confirm spending funds from the merchant client wallet, Or to confirm converting funds. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsSpendConfirmationByIdV1
     * @param mixed $id the id of the wallet which to spend funds from
     * @param array $body WalletSpendConfirmationRequestDto
     */
    public function postMerchantWalletsSpendConfirmationByIdV1(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/wallets/:id/spend/confirmation", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Sends a request to confirm spending funds from the merchant client wallet, Or to confirm converting funds. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsSpendConfirmationByIdV2
     * @param mixed $id the id of the wallet which to spend funds from
     * @param array $body WalletSpendConfirmationRequestDto
     */
    public function postMerchantWalletsSpendConfirmationByIdV2(mixed $id, array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/wallets/:id/spend/confirmation", ["pathParams" => ["id" => $id], "body" => $body, "authed" => true]);
    }


    /**
     * Get transactions count of the wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionsCountByIdV2
     * @param mixed $id the id of the wallet
     */
    public function getMerchantWalletsTransactionsCountByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/wallets/:id/transactions/count", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Get transactions count of the wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionsCountByLabelCurrencyV3
     * @param mixed $label the unique id for the wallet provided by client
     * @param mixed $currency the currency of the wallet to count transactions for
     */
    public function getMerchantWalletsTransactionsCountByLabelCurrencyV3(mixed $label, mixed $currency): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/transactions/count", ["pathParams" => ["label" => $label, "currency" => $currency], "authed" => true]);
    }


    /**
     * Lists transactions of the wallet - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionsByLabelCurrencyV3
     * @param mixed $label the unique id for the wallet provided by client
     * @param mixed $currency the currency of the wallet to list transactions for
     * @param mixed $skip how many transactions to skip (used for paging)
     * @param mixed $take how many transactions to take (used for paging)
     */
    public function getMerchantWalletsTransactionsByLabelCurrencyV3(mixed $label, mixed $currency, mixed $skip = null, mixed $take = null): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/transactions", ["pathParams" => ["label" => $label, "currency" => $currency], "query" => ["skip" => $skip, "take" => $take], "authed" => true]);
    }


    /**
     * Get a specific transaction of the wallet, if transactionId is specified for search then the spendRequestId is ignored otherwise a first spending transaction with matching spendRequestId is returned - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsTransactionByLabelCurrencyV3
     * @param mixed $label the unique id for the wallet provided by client
     * @param mixed $currency the currency of the wallet to search transactions in
     * @param mixed $transactionId Id of the transaction to look for
     * @param mixed $spendRequestId SpendRequestId of the transaction to look for
     */
    public function getMerchantWalletsTransactionByLabelCurrencyV3(mixed $label, mixed $currency, mixed $transactionId = null, mixed $spendRequestId = null): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/transaction", ["pathParams" => ["label" => $label, "currency" => $currency], "query" => ["transactionId" => $transactionId, "spendRequestId" => $spendRequestId], "authed" => true]);
    }


    /**
     * Sends a request to spend funds from the merchant client wallet. Also used to convert funds between supported cryptocurrencies - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsSpendRequestByLabelCurrencyV3
     * @param mixed $label the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet to spend funds from
     * @param array $body SpendRequestV2Dto
     */
    public function postMerchantWalletsSpendRequestByLabelCurrencyV3(mixed $label, mixed $currency, array $body): mixed
    {
        return $this->http->call("POST", "/api/v3/merchant/wallets/:label/:currency/spend/request", ["pathParams" => ["label" => $label, "currency" => $currency], "body" => $body, "authed" => true]);
    }


    /**
     * Sends a request to confirm spending funds from the merchant client wallet, Or to confirm converting funds. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsSpendConfirmationByLabelCurrencyV3
     * @param mixed $label the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet to confirm spending from
     * @param array $body WalletSpendConfirmationRequestDto
     */
    public function postMerchantWalletsSpendConfirmationByLabelCurrencyV3(mixed $label, mixed $currency, array $body): mixed
    {
        return $this->http->call("POST", "/api/v3/merchant/wallets/:label/:currency/spend/confirmation", ["pathParams" => ["label" => $label, "currency" => $currency], "body" => $body, "authed" => true]);
    }


    /**
     * Returns info about merchant wallet consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsConsolidationByLabelCurrencyV3
     * @param mixed $label the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet to get consolidation info for
     * @param mixed $uniqueAddressLabels Comma-separated unique labels of addresses for consolidation
     */
    public function getMerchantWalletsConsolidationByLabelCurrencyV3(mixed $label, mixed $currency, mixed $uniqueAddressLabels = null): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/consolidation", ["pathParams" => ["label" => $label, "currency" => $currency], "query" => ["uniqueAddressLabels" => $uniqueAddressLabels], "authed" => true]);
    }


    /**
     * Executes merchant wallet consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationByLabelCurrencyToV3
     * @param mixed $label the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet to consolidate funds from
     * @param mixed $to the label of the wallet which will be receiving funds
     * @param mixed $uniqueAddressLabels Comma-separated unique address labels for consolidation
     */
    public function postMerchantWalletsConsolidationByLabelCurrencyToV3(mixed $label, mixed $currency, mixed $to, mixed $uniqueAddressLabels = null): mixed
    {
        return $this->http->call("POST", "/api/v3/merchant/wallets/:label/:currency/consolidation/:to", ["pathParams" => ["label" => $label, "currency" => $currency, "to" => $to], "query" => ["uniqueAddressLabels" => $uniqueAddressLabels], "authed" => true]);
    }


    /**
     * Execute merchant wallets consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationByToV3
     * @param mixed $to the ID of the wallet which will be receiving funds (optional)
     * @param array $body WalletsConsolidationRequestV3Dto
     */
    public function postMerchantWalletsConsolidationByToV3(mixed $to, array $body): mixed
    {
        return $this->http->call("POST", "/api/v3/merchant/wallets/consolidation/:to", ["pathParams" => ["to" => $to], "body" => $body, "authed" => true]);
    }


    /**
     * Preview merchant wallets consolidation (sending funds to the main wallet) - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/postMerchantWalletsConsolidationPreviewV3
     * @param array $body WalletsConsolidationRequestV3Dto
     */
    public function postMerchantWalletsConsolidationPreviewV3(array $body): mixed
    {
        return $this->http->call("POST", "/api/v3/merchant/wallets/consolidation-preview", ["body" => $body, "authed" => true]);
    }


    /**
     * Lists transactions used for consolidating funds to pay fee for the withdrawal - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/transactions/routes/getMerchantWalletsConsolidationTransactionsByLabelCurrencyIdV3
     * @param mixed $label the unique label for the wallet provided by client
     * @param mixed $currency the currency of the wallet to list consolidation transactions for
     * @param mixed $id ID of the withdrawal (spend request)
     */
    public function getMerchantWalletsConsolidationTransactionsByLabelCurrencyIdV3(mixed $label, mixed $currency, mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v3/merchant/wallets/:label/:currency/consolidation-transactions/:id", ["pathParams" => ["label" => $label, "currency" => $currency, "id" => $id], "authed" => true]);
    }
}
