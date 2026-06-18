<?php
// Webhook signature verification.
// CoinPayments webhooks carry the same three signing headers as outbound
// requests, so verification is the same HMAC math in reverse.
//
// https://docs.coinpayments.net/api/webhooks/authenticating-requests/

declare(strict_types=1);

namespace CoinPayments\Runtime;

final class WebhookResult
{
    public function __construct(
        public readonly bool $ok,
        public readonly string $reason = "",
    ) {}
}

final class WebhookVerifier
{
    private const BOM = "\xEF\xBB\xBF";

    /**
     * Verify a CoinPayments webhook request.
     *
     * @param string $method       HTTP method of the webhook (typically "POST").
     * @param string $url          Full URL the webhook was delivered to - the URL
     *                             you registered, not what your framework
     *                             reconstructs behind proxies.
     * @param string $rawBody      Request body as a raw string, before any parsing.
     *                             JSON parsers may re-serialise with different
     *                             whitespace, which invalidates the signature.
     * @param array  $headers      Request headers (case-insensitive lookup).
     * @param string $clientSecret Your integration's client secret.
     * @param string|null $expectedClientId Optional: reject if Client header
     *                             does not match.
     * @param int    $maxAgeSeconds Reject if timestamp drifts more than this;
     *                              0 disables the check.
     */
    public static function verify(
        string $method,
        string $url,
        string $rawBody,
        array $headers,
        string $clientSecret,
        ?string $expectedClientId = null,
        int $maxAgeSeconds = 300,
    ): WebhookResult {
        // Case-insensitive header lookup.
        $h = [];
        foreach ($headers as $k => $v) $h[strtolower((string)$k)] = $v;
        $clientId = $h["x-coinpayments-client"]    ?? null;
        $ts       = $h["x-coinpayments-timestamp"] ?? null;
        $sig      = $h["x-coinpayments-signature"] ?? null;

        if (!$clientId || !$ts || !$sig) {
            return new WebhookResult(false, "missing signature headers");
        }
        if ($expectedClientId !== null && $clientId !== $expectedClientId) {
            return new WebhookResult(false, "client id mismatch");
        }

        if ($maxAgeSeconds > 0) {
            $sent = \DateTimeImmutable::createFromFormat("Y-m-d\\TH:i:s", $ts, new \DateTimeZone("UTC"));
            if ($sent === false) {
                return new WebhookResult(false, "malformed timestamp");
            }
            $age = abs(time() - $sent->getTimestamp());
            if ($age > $maxAgeSeconds) {
                return new WebhookResult(false, "timestamp too old ({$age}s)");
            }
        }

        $message = self::BOM . $method . $url . $clientId . $ts . $rawBody;
        $expected = base64_encode(hash_hmac("sha256", $message, $clientSecret, true));

        // Constant-time comparison - never plain `===` for signature checks.
        if (!hash_equals($expected, $sig)) {
            return new WebhookResult(false, "signature mismatch");
        }

        return new WebhookResult(true);
    }
}
