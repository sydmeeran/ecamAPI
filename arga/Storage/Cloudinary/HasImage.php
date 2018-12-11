<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 7/5/18
 * Time: 3:14 PM
 */

namespace Arga\Storage\Cloudinary;

/**
 * @property \Arga\Storage\Cloudinary\Image image
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany images
 */
trait HasImage
{
    /**
     * @return mixed
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function getThumbnailUrl($options = []): ?string
    {
        if ($this->image) {
            return $this->image->getThumbnailUrl($options);
        }

        return null;
    }

    public function getThumbnailUrls($options = []): array
    {
        $output = [];
        foreach ($this->images as $image) {
            if ($image instanceof Image) {
                array_push($output, $image->getThumbnailUrl($options));
            }
        }

        return $output;
    }

    /**
     * @return array|null
     */
    public function getImage(): ?array
    {
        if ($this->image) {
            return $this->image->toAll();
        }

        return null;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        $output = [];
        foreach ($this->images as $image) {
            if ($image instanceof Image) {
                array_push($output, $image->toAll());
            }
        }

        return $output;
    }
}
