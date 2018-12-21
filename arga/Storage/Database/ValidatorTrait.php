<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/20/18
 * Time: 11:42 AM
 */

namespace Arga\Storage\Database;

use Illuminate\Validation\ValidationException;

trait ValidatorTrait
{
    public function validate($data, $rules)
    {
        $v = \Validator::make($data, $rules);
        if ($v->passes()) {
            return true;
        }

        throw new ValidationException($v);
    }
}
