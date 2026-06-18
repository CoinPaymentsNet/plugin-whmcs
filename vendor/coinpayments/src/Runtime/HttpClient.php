<?php
// CoinPayments HTTP transport - signs, calls, returns JSON.

declare(strict_types=1);

namespace CoinPayments\Runtime;

final class CoinPaymentsException extends \RuntimeException
{
    public function __construct(
        public readonly int $status,
        string $message,
        public readonly mixed $payload = null,
    ) {
        parent::__construct("[{$status}] {$message}");
    }
}

final class HttpClient
{
    public function __construct(
        private string $baseUrl,
        private ?string $clientId = null,
        private ?string $clientSecret = null,
    ) {
        $this->baseUrl = rtrim($baseUrl, "/");
    }

    /**
     * @param array{pathParams?: array<string,mixed>, query?: array<string,mixed>, body?: mixed, authed?: bool} $opts
     */
    public function call(string $method, string $path, array $opts = []): mixed
    {
        $pathParams = $opts["pathParams"] ?? null;
        $query      = $opts["query"]      ?? null;
        $body       = $opts["body"]       ?? null;
        $authed     = $opts["authed"]     ?? true;

        // 1. Substitute path params. Routes use Express-style `:name` tokens -
        //    `\b` keeps `:id` from clobbering a longer name like `:identity`.
        if ($pathParams) {
            foreach ($pathParams as $key => $value) {
                $pattern = "/:" . preg_quote((string)$key, "/") . "\\b/";
                $count = 0;
                $path = preg_replace($pattern, rawurlencode((string)$value), $path, -1, $count);
                if ($count === 0) {
                    throw new \RuntimeException("path template has no placeholder :{$key}");
                }
            }
        }
        if (preg_match("/:[A-Za-z_]\\w*/", $path, $m)) {
            throw new \RuntimeException("unresolved path placeholder {$m[0]} in {$path}");
        }

        // 2. Build URL.
        $qs = $this->buildQueryString($query);
        $url = $this->baseUrl . $path . $qs;

        // 3. Serialise body once; same string signed and sent.
        $payload = "";
        if ($body !== null) {
            $encoded = json_encode($body, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
            if ($encoded === false) {
                // JSON_THROW_ON_ERROR makes this unreachable on PHP 7.3+, but
                // we keep the guard so a future flag change can't silently
                // ship `false` as the wire payload.
                throw new \RuntimeException("failed to JSON-encode body: " . json_last_error_msg());
            }
            $payload = $encoded;
        }

        // 4. Headers.
        $headers = ["Accept: application/json"];
        if ($payload !== "") $headers[] = "Content-Type: application/json";

        if ($authed) {
            if (!$this->clientId || !$this->clientSecret) {
                throw new \RuntimeException("{$method} {$path} requires client credentials");
            }
            [$ts, $sig] = Signer::sign($method, $url, $this->clientId, $this->clientSecret, $payload);
            $headers[] = "X-CoinPayments-Client: {$this->clientId}";
            $headers[] = "X-CoinPayments-Timestamp: {$ts}";
            $headers[] = "X-CoinPayments-Signature: {$sig}";
        }

        // 5. Send via curl.
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => $payload !== "" ? $payload : null,
        ]);
        $responseBody = curl_exec($ch);
        if ($responseBody === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException("HTTP transport error: {$err}");
        }
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // 6. Decode.
        $decoded = $responseBody === "" ? null : json_decode($responseBody, true);

        if ($status >= 400) {
            throw new CoinPaymentsException(
                $status,
                "Request failed",
                $decoded ?? $responseBody,
            );
        }
        return $decoded;
    }

    private function buildQueryString(?array $query): string
    {
        if (!$query) return "";
        $flat = [];
        foreach ($query as $k => $v) {
            if ($v === null) continue;
            if (is_array($v)) {
                $flat[$k] = implode(",", array_map([self::class, "queryStr"], $v));
            } else {
                $flat[$k] = self::queryStr($v);
            }
        }
        if (!$flat) return "";
        return "?" . http_build_query($flat);
    }

    private static function queryStr(mixed $v): string
    {
        if (is_bool($v)) return $v ? "true" : "false";
        return (string)$v;
    }
}
