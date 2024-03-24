<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clicks extends Model
{
    protected $table = "clicks";

    protected $fillable = [
        "link_token",
        "user_token",
        "user_agent",
        "ip_address",
        "referer",
        "country",
        "city",
        "region",
        "latitude",
        "longitude",
    ];

    public function link()
    {
        return $this->belongsTo(Links::class, "link_token", "token");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_token", "token");
    }

}
