<?php

namespace Arga\Storage\Cloudinary;

use Arga\Storage\Database\Contracts\SerializableModel;
use Arga\Storage\Database\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property \Doctrine\DBAL\Schema\Column name
 * @property \Doctrine\DBAL\Schema\Column path
 * @property \Doctrine\DBAL\Schema\Column cloud_service
 */
class Image extends BaseModel implements SerializableModel
{
    use SoftDeletes;

    protected $table = 'images';

    protected $fillable = [
        'name',
        'cloud_service',
        'path',
    ];

    public function related_model()
    {
        return $this->morphTo();
    }

    public function getRelatedModel()
    {
        return $this->getRelationValue('related_model');
    }

    protected function getUrl($options = [])
    {
        return cloudinary_url($this->path, $options);
    }

    /**
     * @param array $options
     * @return mixed|null|string|string[]
     */
    protected function getThumbnailUrl($options = [])
    {
        if ($options) {
            return $this->getUrl($options);
        }

        return $this->getUrl([
            'height'  => 150,
            'quality' => 50,
            'crop'    => 'thumb',
        ]);
    }

    public function toOriginal(): array
    {
        return [
            'id'            => $this->getId(),
            'cloud_service' => $this->cloud_service,
            'path'          => $this->path,
            'thumbnail'     => $this->getThumbnailUrl(),
        ];
    }

    public function toAll(): array
    {
        return [
            'id'            => $this->getId(),
            'cloud_service' => $this->cloud_service,
            'path'          => $this->getUrl(),
            'thumbnail'     => $this->getThumbnailUrl(),
            'type'          => 'image',
        ];
    }
}
