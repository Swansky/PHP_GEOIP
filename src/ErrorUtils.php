<?php

class ErrorUtils
{
    public static function SendCriticalError(string $message): void
    {
        echo $message;
        exit();
    }
}