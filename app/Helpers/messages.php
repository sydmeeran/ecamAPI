<?php

function msg_success_login($success)
{
    return response()->json([
        'user' => $success['user'],
        'token' => $success['token'],
        'status' => true
    ]);
}

function msg_unauthenticated()
{
    return [
        'status'  => false,
        'message' => 'Unauthenticated',
    ];
}

function msg_success_logout()
{
    return [
        'status'  => true,
        'message' => 'Your account successfully logout',
    ];
}

