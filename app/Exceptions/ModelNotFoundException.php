<?php


namespace App\Exceptions;


class ModelNotFoundException extends ApiException
{
    protected   $message = "Content not found or doesn't exist.",
                $httpErrorCode = 404;
}
