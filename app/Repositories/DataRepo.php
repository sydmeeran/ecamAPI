<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/11/18
 * Time: 11:54 AM
 */

namespace App\Repositories;

class DataRepo
{
    public static function group_chat(): GroupChatRepository
    {
        return app(GroupChatRepository::class);
    }

}
