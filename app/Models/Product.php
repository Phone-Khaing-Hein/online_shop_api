<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["name", "price", "stock", "user_id"];
    protected $with = ["photos"];

    public function photos(){
        return $this->hasMany(Photo::class);
    }
}
