<?php
// CoinPayments HMAC-SHA256 request signer.
// Spec: https://docs.coinpayments.net/api/auth/generate-api-signature

declare(strict_types=1);

namespace CoinPayments\Runtime;

final class Signer
{
    private const BOM = "\xEF\xBB\xBF";

    /**
     * Sign a CoinPayments API request.
     *
     * IMPORTANT: $payload must be the exact JSON string that will be sent as
     * the request body - any whitespace drift invalidates the signature.
     *
     * @return array{0:string,1:string} [timestamp, signature]
     */
    public static function sign(
        string $method,
        string $url,
        string $clientId,
        string $clientSecret,
        string $payload
    ): array {
        $ts = gmdate("Y-m-d\\TH:i:s");
        $message = self::BOM . $method . $url . $clientId . $ts . $payload;
        $sig = base64_encode(hash_hmac("sha256", $message, $clientSecret, true));
        return [$ts, $sig];
    }
}
