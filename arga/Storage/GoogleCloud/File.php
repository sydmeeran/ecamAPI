<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/17/18
 * Time: 12:38 PM
 */

namespace Arga\Storage\GoogleCloud;

use Arga\Storage\Database\BaseModel;
use Arga\Storage\Database\Contracts\SerializableModel;

/**
 * Class File
 * @property \Doctrine\DBAL\Schema\Column name
 * @property \Doctrine\DBAL\Schema\Column cloud_service
 * @property \Doctrine\DBAL\Schema\Column path
 * @property \Illuminate\Database\Eloquent\Relations\MorphTo related_model
 */
class File extends BaseModel implements SerializableModel
{
    protected $table = 'files';

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

    public function toOriginal(): array
    {
        return [
            'id'            => $this->getId(),
            'cloud_service' => $this->cloud_service,
            'path'          => $this->path,
        ];
    }

    public function toAll(): array
    {
        return [
            'id'            => $this->getId(),
            'cloud_service' => $this->cloud_service,
            'path'          => $this->path,
        ];
    }
}
