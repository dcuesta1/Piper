<?php


namespace App\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception
{
    protected   $httpErrorCode = 500,
                $message = "Unknown server error, please try again later.",
                $httpResponse = [];

    public function __construct($message = "", $httpErrorCode = null, $code = 0, Throwable $previous = null)
    {
        $message = $message ? $message : $this->message;
        $this->httpErrorCode = $httpErrorCode ? $httpErrorCode : $this->httpErrorCode;
        $this->httpResponse[$this->httpErrorCode] = $message;

        parent::__construct($message, $code, $previous);
    }

    public function setHttpErrorCode(int $code)
    {
        $this->httpErrorCode = $code;
    }

    public function getHttpErrorCode()
    {
        return $this->httpErrorCode;
    }

    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    public function render($req)
    {
        return response()->json($this->httpResponse, $this->httpErrorCode);
    }
}
