<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCountry(): ?Country
    {
        if ($userDetails = $this->getUserDetails()){
            return $userDetails->getCountry();
        }

        return null;
    }

    public function getUserDetails(): ?UserDetails
    {
        return $this->user_details()->first();
    }

    public function user_details(): HasOne
    {
        return $this->hasOne(UserDetails::class, 'user_id');
    }
}
