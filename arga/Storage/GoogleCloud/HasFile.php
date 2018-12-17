<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/17/18
 * Time: 12:50 PM
 */

namespace Arga\Storage\GoogleCloud;

/**
 * Trait HasFile
 *
 * @property \Illuminate\Database\Eloquent\Relations\MorphOne file
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany files
 */
trait HasFile
{
    public function file()
    {
        return $this->morphOne(File::class, 'related_model');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'related_model');
    }

    /**
     * @return array|null
     */
    public function getFile()
    {
        $file = $this->file;
        if ($file && $file instanceof File) {
            return $file->toAll();
        }

        return null;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        $output = [];
        foreach ($this->files as $file) {
            if ($file instanceof File) {
                array_push($output, $file->toAll());
            }
        }

        return $output;
    }
}
