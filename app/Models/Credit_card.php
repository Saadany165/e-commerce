<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Credit_card extends Model
{
    protected $fillable =[
        "id",
        "user_id",
        "cardholder_name",
        "card_number",
        "expiry_date",
        "card_type",
        "cvv"
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
