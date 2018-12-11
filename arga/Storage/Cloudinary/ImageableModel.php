<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 7/5/18
 * Time: 3:11 PM
 */

namespace Arga\Storage\Cloudinary;

interface ImageableModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images();

}
