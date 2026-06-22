# CoinPayments WHMCS Gateway

SDK-based CoinPayments gateway module for WHMCS.

[Documentation](https://docs.coinpayments.net/knowledge/plugins/whmcs)

Read more about optimizing your CoinPayments configuration. ([Integration Options](https://docs.coinpayments.net/knowledge/integration-options/))

## Before You Install

You need:

- PHP 8.1 or newer
- WHMCS 9.0 or newer
- PHP `curl` and `json` extensions
- [CoinPayments account](https://docs.coinpayments.net/knowledge/integration-guide/account-setup#create-your-account)
- [Completed CoinPayments compliance verification](https://docs.coinpayments.net/knowledge/integration-guide/account-setup#account-verification)
- [CoinPayments API integration with Client ID and Client Secret](https://docs.coinpayments.net/api/auth/create-integration)

## 1. Create Your CoinPayments Account

Create a CoinPayments account first:
https://www.coinpayments.net/register

After registering:

1. Confirm your email.
2. Enable two-factor authentication.
3. Sign in to the CoinPayments dashboard.

Full guide:
https://docs.coinpayments.net/knowledge/integration-guide/account-setup/

## 2. Complete Compliance Verification

Compliance verification is required before commercial tools are available, including:

- Invoicing
- API integrations
- eCommerce plugins
- Payment collection tools

Use the account setup guide and complete the required personal or business verification steps:
https://docs.coinpayments.net/knowledge/integration-guide/account-setup/

> [LTCT](https://docs.coinpayments.net/api/testing-currency) is available for testing prior to compliance verification.

## 3. Find Your CoinPayments Instance

CoinPayments accounts are routed to instance `A`, `B`, or `C` based on business registration country.

Find your instance here:
https://docs.coinpayments.net/instances/

The WHMCS setting maps instances automatically:

- `A` -> `https://a-api.coinpayments.net`
- `B` -> `https://b-api.coinpayments.net`
- `C` -> `https://c-api.coinpayments.net`

## 4. Create API Keys

In the CoinPayments dashboard:

1. Open **Integrations**.
2. Click **Add Integration**.
3. Choose **API Integrations**.
4. Enter your WHMCS store name and store URL.
5. Copy the **Client ID** and **Client Secret**.
6. Save the secret immediately. It is only shown once.

Guide:
https://docs.coinpayments.net/api/auth/create-integration/

## 5. Install The WHMCS Plugin

Upload these folders to the root of your WHMCS installation:

- `modules/`
- `vendor/`

After upload, these files should exist:

- `modules/gateways/coinpayments.php`
- `modules/gateways/callback/coinpayments.php`
- `modules/gateways/coinpayments/lib/api.php`
- `modules/gateways/coinpayments/test_connection.php`
- `vendor/coinpayments`

## 6. Configure WHMCS

In WHMCS Admin, activate and configure the CoinPayments integration using either of the following paths.

### Option 1: Configure from Apps & Integrations

1. Open **Apps & Integrations** (Marketplace).
2. Search for **CoinPayments**.
3. Click **Activate** on the CoinPayments integration.
4. After activation, click **Manage** from the same screen.
5. Enter your **Client ID**.
6. Enter your **Client Secret**.
7. Choose your CoinPayments **Instance**: `A`, `B`, or `C`.
8. Click **Save Changes**.
9. Click **Test Connection**.

### Option 2: Configure from Payment Gateways

1. Open **Apps & Integrations** (Marketplace).
2. Search for **CoinPayments**.
3. Click **Activate** on the CoinPayments integration.
4. Go to **System Settings > Payment Gateways**.
5. Under active gateways, open **CoinPayments**.
6. Enter your **Client ID**.
7. Enter your **Client Secret**.
8. Choose your CoinPayments **Instance**: `A`, `B`, or `C`.
9. Click **Save Changes**.
10. Click **Test Connection**.

The **Test Connection** button calls `getMerchantWalletsV2(0, 1)` using the saved instance and credentials. A successful result confirms that API credentials and entity routing are valid.

## 7. Enable Webhooks

In the WHMCS CoinPayments settings:

1. Check **Enable Webhooks**.
2. Check **Auto-register Webhook**.
3. Click **Save Changes**.

The module registers this callback URL:
`https://your-whmcs-host/modules/gateways/callback/coinpayments.php`

Webhook guide:
https://docs.coinpayments.net/api/webhooks/

## 8. Test Payment Reconciliation

Before going live:

1. Create a small WHMCS test invoice.
2. Open the invoice as a client.
3. Click **Pay with CoinPayments**.
4. Complete the hosted checkout.
5. Confirm WHMCS marks the invoice as paid.
6. Confirm the WHMCS transaction ID matches the CoinPayments invoice/payment event.
7. Review WHMCS gateway logs for webhook delivery or signature errors.
8. Confirm duplicate webhook deliveries do not create duplicate WHMCS payments.

Useful references:

- Invoice status route: https://docs.coinpayments.net/api/invoices/routes/getInvoicesPaymentCurrenciesStatusByIdCurrencyV1/
- Webhooks: https://docs.coinpayments.net/api/webhooks/
- Integration options: https://docs.coinpayments.net/knowledge/integration-options/

## How The Plugin Works

- Invoices are created with the SDK `postMerchantInvoicesV2` route.
- Checkout uses the returned `checkoutLink`.
- The checkout opens with `target="_blank"` and `rel="noopener noreferrer"`.
- Webhooks are verified with the SDK `WebhookVerifier`.
- Paid/completed webhook events call WHMCS `addInvoicePayment`.
- Duplicate transaction IDs are rejected through WHMCS `checkCbTransID`.
- The plugin caches a created CoinPayments invoice in the customer session to avoid duplicate invoice creation during invoice-page refreshes.

## Troubleshooting

If **Test Connection** fails:

- Confirm the gateway settings were saved before testing.
- Confirm the selected instance matches your account.
- Confirm the Client ID and Client Secret belong to the same instance.
- Confirm API integration credentials were copied correctly.
- Check whether IP restrictions were added to the CoinPayments integration.

If invoice creation fails:

- Check WHMCS gateway logs for the CoinPayments API response payload.
- Confirm the WHMCS invoice currency is supported by CoinPayments.
- Confirm the API integration has invoice permissions.

If payment reconciliation fails:

- Confirm webhooks are enabled in WHMCS.
- Confirm the callback URL is publicly reachable over HTTPS.
- Confirm Auto-register Webhook completed without errors.
- Confirm WHMCS server time is accurate; webhook signatures use timestamp freshness checks.

## Tested Environment

CoinPayments tested this WHMCS gateway module using the following environment:

* WHMCS: 9.0.5-release.1
* PHP: 8.2.31 (with IonCube Loader 15.5.0)
* Debian 13

Merchants should validate the module in their own environment before accepting live payments.

## Disclaimer

This WHMCS gateway module has been tested by CoinPayments in the tested environment listed above for standard installation, configuration, invoice creation, checkout, webhook handling, and payment reconciliation workflows.

This module is provided on an **as-is** and **as-available** basis. CoinPayments does not guarantee that the module will be error-free, uninterrupted, compatible with every WHMCS environment, or suitable for every merchant configuration.

While reasonable testing has been completed to help prevent issues such as duplicate credits, incorrect payment amounts, webhook failures, or reconciliation errors, merchants are responsible for validating the module in their own WHMCS environment before accepting live payments.

Before going live, create and reconcile several low-value test invoices, confirm webhook delivery, review WHMCS gateway logs, and verify that invoice amounts, currencies, transaction IDs, and payment statuses are recorded correctly.

Use of this module is subject to CoinPayments’ applicable [User Agreement and Privacy Policy](https://www.coinpayments.net/legal). Please review those documents before installing, configuring, or using this module.

If you encounter any unexpected behaviour, payment mismatch, duplicate credit, webhook failure, or reconciliation issue, please bring it to CoinPayments’ attention immediately so it can be reviewed and addressed at https://docs.coinpayments.net/contact/integrations/.

## License

This WHMCS gateway module is licensed under the terms specified in the `LICENSE` file included with this repository.

Please review the `LICENSE` file before using, modifying, or distributing this module.

![Screenshot](https://user-images.githubusercontent.com/72504315/116075363-b7b65200-a647-11eb-977e-065c1c052869.png)

