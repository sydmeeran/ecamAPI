<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class RoleDeleteException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(){
        $error_message = [
            'message' => 'User Has Registered With This Role'
        ];
        return response()->json($error_message, 401);
    }
}
