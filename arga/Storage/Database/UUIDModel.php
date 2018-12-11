<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 8/28/18
 * Time: 4:41 PM
 */

namespace Arga\Storage\Database;

trait UUIDModel
{
    protected static function bootUUIDModel()
    {
        static::creating(function ($model) {
            do {
                $uuid = self::generateId();
            } while (static::find($uuid));

            $model->{$model->getKeyName()} = $uuid;
        });
    }

    protected static function generateId()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = strlen($characters);
        $prefix = 'a0';
        $random = $prefix.'';
        for ($i = 0; $i < 10; $i++) {
            $random .= $characters[rand(0, $length - 1)];
        }

        return $random;
    }

}