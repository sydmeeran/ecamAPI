<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 7/3/18
 * Time: 12:05 PM
 */

namespace Arga\Storage\Cloudinary;

interface ImageDisplayable
{
    public function getImageUrl(): ?string;

    public function getThumbnailUrl(): ?string;
}
