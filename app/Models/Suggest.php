<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    use HasFactory;

    
    protected $fillable = ['suggest_price', 'suggest_date', 'introduction', 'first_suggest', 'user_id', 'order_id'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
    public function order()
    {

        return $this->belongsTo(order::class, 'order_id');
    }

}


