<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'order_id'];

    protected $casts = ['image' => 'array'];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
