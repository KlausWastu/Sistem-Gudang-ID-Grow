<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $casts = [
        "created_at" => "datetime: Y-m-d H:m:s",
        "updated_at" => "datetime: Y-m-d H:m:s",
    ];

    protected $table = "locations";

    protected $fillable = [
        "name", "google_map"
    ];
}
