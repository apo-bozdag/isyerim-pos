<?php

namespace Abdullah\IsyerimPos\Exceptions;

use Illuminate\Http\Client\Response;

class ApiException extends IsyerimPosException
{
    public static function requestFailed(Response $response): self
    {
        $body = $response->json();
        $message = $body['message'] ?? $body['error'] ?? 'API request failed';
        $code = $body['code'] ?? $response->status();

        return new self("IsyerimPOS API Error: {$message} (HTTP {$code})");
    }

    public static function timeout(): self
    {
        return new self('IsyerimPOS API request timed out.');
    }

    public static function networkError(string $message): self
    {
        return new self("Network error: {$message}");
    }
}
