<?php

namespace App\Exceptions;

use Exception;

class ApiKeyException extends Exception
{
    public function render(){
        $message = [
            'message' => 'Unauthorized'
        ];
        return response()->json($message, 401);
    }
}
