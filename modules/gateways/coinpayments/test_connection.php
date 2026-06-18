<?php
/**
 * CoinPayments WHMCS Gateway
 *
 * SDK-based CoinPayments payment gateway module for WHMCS.
 *
 * @package    CoinPayments_WHMCS_Gateway
 * @author     CoinPayments
 * @copyright  Copyright (c) CoinPayments
 * @license    See LICENSE file
 * @version    1.0.0
 * @link       https://www.coinpayments.net/
 *
 * For full license terms, see the LICENSE file included with this repository.
 */

require_once __DIR__ . '/lib/api.php';
require_once __DIR__ . '/../../../init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array(
        'ok' => false,
        'message' => 'POST required.',
    ));
    exit;
}

if (empty($_SESSION['adminid'])) {
    http_response_code(403);
    echo json_encode(array(
        'ok' => false,
        'message' => 'Admin session required.',
    ));
    exit;
}

$whmcs->load_function('gateway');

$params = getGatewayVariables(COINPAYMENTS_MODULE_NAME);
if (empty($params['type'])) {
    http_response_code(400);
    echo json_encode(array(
        'ok' => false,
        'message' => 'CoinPayments gateway is not active.',
    ));
    exit;
}

try {
    $gateway = new CoinPaymentsWhmcsGateway($params);
    $result = $gateway->testConnection();

    echo json_encode(array(
        'ok' => true,
        'message' => sprintf(
            'Connected to instance %s. API credentials and routing are valid.',
            $result['instance']
        ),
        'details' => $result,
    ));
} catch (Throwable $exception) {
    coinpayments_log('Test connection failed', array(
        'error' => $exception->getMessage(),
        'payload' => property_exists($exception, 'payload') ? $exception->payload : null,
    ));

    http_response_code(400);
    echo json_encode(array(
        'ok' => false,
        'message' => 'Connection failed: ' . $exception->getMessage(),
        'payload' => property_exists($exception, 'payload') ? $exception->payload : null,
    ));
}
