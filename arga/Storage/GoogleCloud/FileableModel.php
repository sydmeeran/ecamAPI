<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/17/18
 * Time: 12:56 PM
 */

namespace Arga\Storage\GoogleCloud;

interface FileableModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function file();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files();

}
