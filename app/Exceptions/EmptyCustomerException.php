<?php

namespace App\Exceptions;

use Exception;

class EmptyCustomerException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(){
        $error_message = [
            'message' => 'Register Customer First'
        ];
        return response()->json($error_message, 401);
    }
}
