<?php

namespace Abdullah\IsyerimPos\Exceptions;

class AuthenticationException extends IsyerimPosException
{
    public static function invalidCredentials(): self
    {
        return new self('Invalid IsyerimPOS API credentials. Please check your merchant_id, user_id, and api_key.');
    }

    public static function missingCredentials(): self
    {
        return new self('Missing IsyerimPOS API credentials. Please configure merchant_id, user_id, and api_key.');
    }
}
