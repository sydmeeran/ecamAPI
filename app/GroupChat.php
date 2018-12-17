<?php

namespace App;

use Arga\Helpers\FontChecker;
use Arga\Storage\Cloudinary\HasImage;
use Arga\Storage\Cloudinary\ImageableModel;
use Arga\Storage\Database\BaseModel;
use Arga\Storage\Database\Contracts\SerializableModel;
use Arga\Storage\GoogleCloud\FileableModel;
use Arga\Storage\GoogleCloud\HasFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rabbit;

/**
 * Class GroupChat
 *
 * @property \Doctrine\DBAL\Schema\Column sender_id
 * @property \Doctrine\DBAL\Schema\Column message
 * @property \Doctrine\DBAL\Schema\Column assigned_id
 * @property \Doctrine\DBAL\Schema\Column created_at
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo user
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo assigned
 */
class GroupChat extends BaseModel implements SerializableModel, ImageableModel, FileableModel
{
    use SoftDeletes;
    use HasImage;
    use HasFile;

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

    public function setMessageAttribute($value)
    {
        if (FontChecker::isZawgyi($value)) {
            $value = Rabbit::zg2uni($value);
        }

        $this->attributes['message'] = $value;
    }

    public function getCreatedAt()
    {
        return Carbon::parse($this->created_at)->format('d-M-Y g:i A');
    }

    public function toOriginal(): array
    {
        return [
            'id'          => $this->getId(),
            'sender_id'   => $this->sender_id,
            'message'     => [
                'message' => $this->message,
                'image'   => $this->getImage(),
                'file'    => $this->getFile(),
            ],
            'assigned_id' => $this->assigned_id,
            'user'        => $this->user,
            'assigned'    => $this->assigned,
            'send_date'   => $this->getCreatedAt(),
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
                'file'    => $this->getFile(),
            ],
            'assigned_id' => $this->assigned_id,
            'user'        => $this->user,
            'assigned'    => $this->assigned,
            'send_date'   => $this->getCreatedAt(),
        ];
    }
}
