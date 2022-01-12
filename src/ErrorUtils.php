<?php

class ErrorUtils
{
    public static function SendCriticalError(string $message): void
    {
        exit($message);
    }
}