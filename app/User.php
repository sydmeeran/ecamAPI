<?php

namespace App;

use Arga\Storage\Database\Contracts\SerializableModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @property \Doctrine\DBAL\Schema\Column id
 * @property \Doctrine\DBAL\Schema\Column name
 * @property \Doctrine\DBAL\Schema\Column email
 * @property \Doctrine\DBAL\Schema\Column position
 * @property \Doctrine\DBAL\Schema\Column nrc_no
 * @property \Doctrine\DBAL\Schema\Column nrc_photo
 * @property \Doctrine\DBAL\Schema\Column phone_no
 * @property \Doctrine\DBAL\Schema\Column address
 * @property \Doctrine\DBAL\Schema\Column role_id
 * @property \Doctrine\DBAL\Schema\Column is_active
 * @property \Doctrine\DBAL\Schema\Column profile_photo
 */
class User extends Authenticatable implements SerializableModel
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'position',
        'nrc_no',
        'nrc_photo',
        'phone_no',
        'address',
        'password',
        'role_id',
        'is_active',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getProfilePhotoUrl()
    {
        return Storage::disk('profile_photo')->url($this->profile_photo);
    }

    public function toOriginal(): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'position'      => $this->position,
            'nrc_no'        => $this->nrc_no,
            'nrc_photo'     => $this->nrc_photo,
            'phone_no'      => $this->phone_no,
            'address'       => $this->address,
            'role_id'       => $this->role_id,
            'is_active'     => $this->is_active,
            'profile_photo' => $this->profile_photo,
        ];
    }

    public function toAll(): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'position'          => $this->position,
            'nrc_no'            => $this->nrc_no,
            'nrc_photo'         => $this->nrc_photo,
            'phone_no'          => $this->phone_no,
            'address'           => $this->address,
            'role_id'           => $this->role_id,
            'is_active'         => $this->is_active,
            'profile_photo'     => $this->profile_photo,
            'profile_photo_url' => $this->getProfilePhotoUrl(),
        ];
    }
}
