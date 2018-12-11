<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 9/18/18
 * Time: 12:58 PM
 */

namespace Arga\Storage\Database;

use Illuminate\Support\Facades\Schema;

trait SubUUIDModel
{
    protected static $uuid_model = false;

    protected static function bootSubUUIDModel()
    {
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'uuid')) {
                static::$uuid_model = true;
            }
            if (static::$uuid_model) {
                $uuid = static::generateIdV1();

                while (static::find($uuid)) {
                    $uuid = static::generateIdV1();
                }
                $model->uuid = $uuid;
                static::$uuid_model = false;
            }
        });
    }

    protected static function generateIdV1()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $prefix = 'a0';
        $randomString = $prefix.'';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
