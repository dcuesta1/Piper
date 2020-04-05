<?php


namespace App\Exceptions;


class BadInputException extends ApiException
{
    protected   $message = "Bad Input: Inserted wrong data in input fields",
                $httpErrorCode = 422;
}
