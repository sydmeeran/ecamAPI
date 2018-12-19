<?php

function msg_success_login($token)
{
    return [
        'status' => true,
        'token'  => $token,
    ];
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

