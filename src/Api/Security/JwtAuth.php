<?php

namespace Htlw3r\Dockerwebdemo\Security;

use Htlw3r\Dockerwebdemo\Security\JwtService;

/**
 * Einfache Auth-Klasse zum Prüfen von JWT-Tokens in beliebigen PHP-Skripten.
 *
 * Beispiel:
 *   $auth = new JwtAuth(new JwtService($secret));
 *   if (!$auth->check()) { exit('Unauthorized'); }
 *   $user = $auth->user(); // gibt Payload (z. B. sub, roles)
 */
class JwtAuth
{
    private JwtService $jwtService;
    private ?array $payload = null;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Prüft automatisch den Authorization-Header (Bearer <token>).
     * Gibt true bei gültigem Token zurück, sonst false.
     */
    public function check(): bool
    {
        $token = $this->extractBearerToken();
        if ($token === null) {
            return false;
        }

        $payload = $this->jwtService->verify($token);

        if ($payload === null) {
            return false;
        }

        $this->payload = $payload;
        return true;
    }

    /**
     * Gibt das Payload-Array zurück (nach erfolgreichem check()).
     */
    public function user(): ?array
    {
        return $this->payload;
    }

    /**
     * Optional: erlaubt manuelles Übergeben eines Tokens
     */
    public function validateToken(string $token): bool
    {
        $payload = $this->jwtService->verify($token);
        if ($payload === null) {
            return false;
        }

        $this->payload = $payload;
        return true;
    }

    /**
     * Extrahiert den Bearer-Token aus dem HTTP_AUTHORIZATION Header.
     */
    private function extractBearerToken(): ?string
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        if (!$authHeader && function_exists('getallheaders')) {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
        }

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return null;
        }

        return $matches[1];
    }
}
