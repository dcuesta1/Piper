<?php


namespace App\Exceptions;


class UnauthorizedAccessException extends ApiException
{
    protected   $message = "Access denied: your session might be expired.",
                $httpErrorCode = 401;
}
