<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        "name",
        "description",
        "price",
        "category_id",
        "img"
    ];

    public function category(){
        $this->belongsTo(Category::class);
    }

    public function cart(){
        $this->hasMany(Cart::class);
    }
}
