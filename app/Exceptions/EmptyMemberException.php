<?php

namespace App\Exceptions;

use Exception;

class EmptyMemberException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(){
        $error_message = [
            'message' => 'Register Member First'
        ];
        return response()->json($error_message, 410);
    }
}
