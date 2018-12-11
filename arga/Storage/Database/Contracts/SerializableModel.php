<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 11/19/18
 * Time: 5:23 PM
 */

namespace Arga\Storage\Database\Contracts;

interface SerializableModel
{
    public function toOriginal(): array;

    public function toAll(): array;
}
