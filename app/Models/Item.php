<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $casts = [
        "created_at" => "datetime: Y-m-d H:m:s",
        "updated_at" => "datetime: Y-m-d H:m:s",
    ];

    protected $table = "items";

    protected $fillable = [
        "code", "item_name", "category_id", "location_id", "image", "stock"
    ];

    public function locations(){
        return $this->hasMany("App\Models\Location")->orderBy('id','asc');
    }
    public function categories(){
        return $this->hasMany("App\Models\Category")->orderBy('id','asc');
    }
}
