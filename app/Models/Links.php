<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table = 'links';

    protected $fillable = [
        'token',
        'user_token',
        'original_url',
        'clicks',
        'expiration_date',
    ];

    protected $casts = [
        'expiration_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_token', 'token');
    }

    public function getShortenedUrlAttribute()
    {
        return route('visit', ['token' => $this->token]);
    }
}
