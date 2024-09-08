<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Common\ImageManager;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;


/**
 * @property string $avatar
 * @property string $image
 * @property string $name
 * @property string $email
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, UserTrait;

    public const PASSPORT_CLIENT_NAME = 'users';
//    public const PASSPORT_CLIENT_NAME = 'Laravel Password Grant Client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * @return string|null
     */
    public function getImageUrl(): string|null
    {
        return asset('storage' .  ImageManager::DIR_IMAGES . '/' . $this->image);
    }
}
