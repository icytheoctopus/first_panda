<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'citizenship_country_id'
    ];

    public function getCountry(): ?Country
    {
        return $this->country()->first();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'citizenship_country_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
