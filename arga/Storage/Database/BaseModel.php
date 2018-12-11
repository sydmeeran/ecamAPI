<?php

namespace Arga\Storage\Database;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function getId()
    {
        return $this->getOriginal('id');
    }
}
