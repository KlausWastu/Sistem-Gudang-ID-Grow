<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $casts = [
        "created_at" => "datetime: Y-m-d H:m:s",
        "updated_at" => "datetime: Y-m-d H:m:s",
    ];

    protected $table = "mutations";

    protected $fillable = [
        "date", "type_mutation", "user_id", "item_id", "amount", "start_location", "end_location"
    ];

    public function users() {
        return $this->belongsTo("App\Models\User");
    }

    public function items(){
        return $this->hasMany("App\Models\Item")->orderBy('id','asc');
    }
}
