<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'order_id',
        'stars_rated'
    ];
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
    public function order()
    {

        return $this->belongsTo(order::class, 'order_id');
    }
}
