<?php

namespace App;

use Arga\Storage\Cloudinary\HasImage;
use Arga\Storage\Cloudinary\ImageableModel;
use Arga\Storage\Database\BaseModel;
use Arga\Storage\Database\Contracts\SerializableModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GroupChat
 *
 * @property \Doctrine\DBAL\Schema\Column sender_id
 * @property \Doctrine\DBAL\Schema\Column message
 * @property \Doctrine\DBAL\Schema\Column assigned_id
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo user
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo assigned
 */
class GroupChat extends BaseModel implements SerializableModel, ImageableModel
{
    use SoftDeletes;
    use HasImage;

    protected $table = 'group_chats';

    protected $fillable = [
        'sender_id',
        'message',
        'assigned_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }

    public function toOriginal(): array
    {
        return [
            'id'          => $this->getId(),
            'sender_id'   => $this->sender_id,
            'message'     => [
                'message' => $this->message,
                'image'   => $this->getImage(),
            ],
            'assigned_id' => $this->assigned_id,
            'user'        => $this->user,
            'assigned'    => $this->assigned,
        ];
    }

    public function toAll(): array
    {
        return [
            'id'          => $this->getId(),
            'sender_id'   => $this->sender_id,
            'message'     => [
                'message' => $this->message,
                'image'   => $this->getImage(),
            ],
            'assigned_id' => $this->assigned_id,
            'user'        => $this->user,
            'assigned'    => $this->assigned,
        ];
    }
}
