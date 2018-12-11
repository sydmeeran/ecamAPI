<?php

namespace App\Repositories;

class DataRepo
{
    public static function group_chat(): GroupChatRepository
    {
        return app(GroupChatRepository::class);
    }

    public static function customer(): CustomerRepository
    {
        return app(CustomerRepository::class);
    }

    public static function business(): BusinessRepostitory
    {
        return app(BusinessRepostitory::class);
    }
}
