<?php

namespace Abdullah\IsyerimPos\Exceptions;

class PaymentException extends IsyerimPosException
{
    public static function failed(string $message, ?string $code = null): self
    {
        $errorMessage = "Payment failed: {$message}";

        if ($code) {
            $errorMessage .= " (Code: {$code})";
        }

        return new self($errorMessage);
    }

    public static function invalidAmount(): self
    {
        return new self('Invalid payment amount. Amount must be greater than 0.');
    }

    public static function invalidCard(): self
    {
        return new self('Invalid card information provided.');
    }
}
