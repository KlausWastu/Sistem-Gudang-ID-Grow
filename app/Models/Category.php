<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $casts = [
        "created_at" => "datetime: Y-m-d H:m:s",
        "updated_at" => "datetime: Y-m-d H:m:s",
    ];

    protected $table = "categories";

    protected $fillable = [
        "name"
    ];
}
