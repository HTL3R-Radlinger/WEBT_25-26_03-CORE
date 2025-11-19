<?php

namespace Htlw3r\Dockerwebdemo\Security;

/**
 * Minimalistische JWT-HS256 Implementierung ohne externe Bibliotheken.
 *
 * PSR-12 konform, reine PHP-Standardfunktionen.
 *
 * Verwendung:
 *   $jwt = (new JwtService('mein-shared-secret'))->encode($payload);
 *   $data = (new JwtService('mein-shared-secret'))->verify($token);
 */
class JwtService
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function encode(array $payload, array $header = ['alg' => 'HS256', 'typ' => 'JWT']): string
    {
        $headerB64 = $this->base64UrlEncode(json_encode($header));
        $payloadB64 = $this->base64UrlEncode(json_encode($payload));
        $signature = $this->sign("$headerB64.$payloadB64");
        return "$headerB64.$payloadB64.$signature";
    }

    /**
     * Verifiziert Token und gibt Payload als Array zurück oder null bei Fehler.
     */
    public function verify(string $jwt): ?array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return null;
        }

        [$headerB64, $payloadB64, $signatureB64] = $parts;

        $expectedSig = $this->sign("$headerB64.$payloadB64");

        if (!hash_equals($expectedSig, $signatureB64)) {
            return null;
        }

        $payload = json_decode($this->base64UrlDecode($payloadB64), true);

        if (!is_array($payload)) {
            return null;
        }

        // Ablauf prüfen, falls vorhanden
        if (isset($payload['exp']) && time() > (int)$payload['exp']) {
            return null;
        }

        return $payload;
    }

    private function sign(string $data): string
    {
        $rawSig = hash_hmac('sha256', $data, $this->secret, true);
        return $this->base64UrlEncode($rawSig);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
