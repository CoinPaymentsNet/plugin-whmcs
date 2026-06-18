<?php
// Auto-generated. Do not edit by hand.
declare(strict_types=1);

namespace CoinPayments\Api;

use CoinPayments\Runtime\HttpClient;

final class InvoicesApi
{
    public function __construct(private HttpClient $http) {}

    /**
     * Creates a new invoice - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/postMerchantInvoicesV1
     * @param array $body CreateInvoicePaymentWithCurrencyRequestDtoCreateMerchantInvoiceRequestDto
     */
    public function postMerchantInvoicesV1(array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/invoices", ["body" => $body, "authed" => true]);
    }


    /**
     * Creates a new invoice - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/postMerchantInvoicesV2
     * @param array $body CreateMerchantInvoiceRequestV2Dto
     */
    public function postMerchantInvoicesV2(array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/invoices", ["body" => $body, "authed" => true]);
    }


    /**
     * Cancels an invoice. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/postMerchantInvoicesCancelByIdV1
     * @param mixed $id 
     */
    public function postMerchantInvoicesCancelByIdV1(mixed $id): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/invoices/:id/cancel", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Get a list of the current merchant's invoices - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesV1
     * @param mixed $status optional query to fetch invoices that were created with the specific client
     * @param mixed $from optional query to fetch from and including the time specified up to the current time
     * @param mixed $to optional query to fetch all invoices up to and including the specified time
     * @param mixed $q optional search string to find invoices with these words
     * @param mixed $integration optional integration by which the invoice was created
     * @param mixed $payoutWalletId optional query to filter the invoices by the wallet they were paid out to (for 'paid' and 'completed' invoices)
     * @param mixed $after cursor that points to the end of the page of data that has been returned
     * @param mixed $limit the maximum number of objects that may be returned, the query may return fewer results than the requested maximum.  If `after` is specified then `limit` specifies the number of items to return starting from `after`.  If not specified then `limit` specifies the number of items to return from the beginning.
     */
    public function getMerchantInvoicesV1(mixed $status = null, mixed $from = null, mixed $to = null, mixed $q = null, mixed $integration = null, mixed $payoutWalletId = null, mixed $after = null, mixed $limit = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/invoices", ["query" => ["status" => $status, "from" => $from, "to" => $to, "q" => $q, "integration" => $integration, "payoutWalletId" => $payoutWalletId, "after" => $after, "limit" => $limit], "authed" => true]);
    }


    /**
     * Get a list of the current merchant's invoices - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesV2
     * @param mixed $status optional query to fetch invoices that were created with the specific client
     * @param mixed $from optional query to fetch from and including the time specified up to the current time
     * @param mixed $to optional query to fetch all invoices up to and including the specified time
     * @param mixed $q optional search string to find invoices with these words
     * @param mixed $integration optional integration by which the invoice was created
     * @param mixed $payoutWalletId optional query to filter the invoices by the wallet they were paid out to (for 'paid' and 'completed' invoices)
     * @param mixed $after cursor that points to the end of the page of data that has been returned
     * @param mixed $limit the maximum number of objects that may be returned, the query may return fewer results than the requested maximum.  If `after` is specified then `limit` specifies the number of items to return starting from `after`.  If not specified then `limit` specifies the number of items to return from the beginning.
     */
    public function getMerchantInvoicesV2(mixed $status = null, mixed $from = null, mixed $to = null, mixed $q = null, mixed $integration = null, mixed $payoutWalletId = null, mixed $after = null, mixed $limit = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/invoices", ["query" => ["status" => $status, "from" => $from, "to" => $to, "q" => $q, "integration" => $integration, "payoutWalletId" => $payoutWalletId, "after" => $after, "limit" => $limit], "authed" => true]);
    }


    /**
     * Creates payment button code for the specified invoice - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/postMerchantInvoicesBuyNowButtonV1
     * @param array $body CreateMerchantInvoiceBuyNowButtonHtmlRequestDto
     */
    public function postMerchantInvoicesBuyNowButtonV1(array $body): mixed
    {
        return $this->http->call("POST", "/api/v1/merchant/invoices/buy-now-button", ["body" => $body, "authed" => true]);
    }


    /**
     * Creates payment button code for the specified invoice - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/postMerchantInvoicesBuyNowButtonV2
     * @param array $body CreateMerchantInvoiceBuyNowButtonHtmlRequestV2Dto
     */
    public function postMerchantInvoicesBuyNowButtonV2(array $body): mixed
    {
        return $this->http->call("POST", "/api/v2/merchant/invoices/buy-now-button", ["body" => $body, "authed" => true]);
    }


    /**
     * Provides an object with details for sending payments to the invoice - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/invoices/routes/getInvoicesPaymentCurrenciesByIdCurrencyV1
     * @param mixed $id If of active invoice
     * @param mixed $currency Currency in format 'id' or 'id:contractAddress' for smart contracts
     */
    public function getInvoicesPaymentCurrenciesByIdCurrencyV1(mixed $id, mixed $currency): mixed
    {
        return $this->http->call("GET", "/api/v1/invoices/:id/payment-currencies/:currency", ["pathParams" => ["id" => $id, "currency" => $currency], "authed" => false]);
    }


    /**
     * Returns the current state of the payment object - Supports Auth methods: Anonymous
     * @see https://docs.coinpayments.net/api/invoices/routes/getInvoicesPaymentCurrenciesStatusByIdCurrencyV1
     * @param mixed $id If of active invoice
     * @param mixed $currency Currency in format 'id' or 'id:contractAddress' for smart contracts
     */
    public function getInvoicesPaymentCurrenciesStatusByIdCurrencyV1(mixed $id, mixed $currency): mixed
    {
        return $this->http->call("GET", "/api/v1/invoices/:id/payment-currencies/:currency/status", ["pathParams" => ["id" => $id, "currency" => $currency], "authed" => false]);
    }


    /**
     * Find invoice belonging to merchant by the invoice ID - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesByIdV1
     * @param mixed $id Invoice id
     * @param mixed $includeFullDetails Indicates whether to return information about Merchant, Metadata, Notes to recipient and email delivery settings
     */
    public function getMerchantInvoicesByIdV1(mixed $id, mixed $includeFullDetails = null): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/invoices/:id", ["pathParams" => ["id" => $id], "query" => ["include_full_details" => $includeFullDetails], "authed" => true]);
    }


    /**
     * Find invoice belonging to merchant by the invoice ID - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesByIdV2
     * @param mixed $id Invoice Id
     * @param mixed $includeFullDetails Indicates whether to return information about Merchant, Metadata, Notes to recipient and email delivery settings
     */
    public function getMerchantInvoicesByIdV2(mixed $id, mixed $includeFullDetails = null): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/invoices/:id", ["pathParams" => ["id" => $id], "query" => ["include_full_details" => $includeFullDetails], "authed" => true]);
    }


    /**
     * Get payout details for an invoice, including if invoice has been fully paid out, the exact amount they will receive
and in what currency, which address payout will be deposited, and who (Buyer) performed the payment. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesPayoutsByIdV1
     * @param mixed $id Invoice Id
     */
    public function getMerchantInvoicesPayoutsByIdV1(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/invoices/:id/payouts", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Get payout details for an invoice, including if invoice has been fully paid out, the exact amount they will receive
and in what currency, which address payout will be deposited, and who (Buyer) performed the payment. - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesPayoutsByIdV2
     * @param mixed $id Invoice id
     */
    public function getMerchantInvoicesPayoutsByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/invoices/:id/payouts", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Lists the history events of an invoice by the invoice ID - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesHistoryByIdV1
     * @param mixed $id Invoice id
     */
    public function getMerchantInvoicesHistoryByIdV1(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v1/merchant/invoices/:id/history", ["pathParams" => ["id" => $id], "authed" => true]);
    }


    /**
     * Lists the history events of an invoice by the invoice ID - Supports Auth methods: [ OAuth, clientId/secret ]
     * @see https://docs.coinpayments.net/api/invoices/routes/getMerchantInvoicesHistoryByIdV2
     * @param mixed $id Invoice Id
     */
    public function getMerchantInvoicesHistoryByIdV2(mixed $id): mixed
    {
        return $this->http->call("GET", "/api/v2/merchant/invoices/:id/history", ["pathParams" => ["id" => $id], "authed" => true]);
    }
}
