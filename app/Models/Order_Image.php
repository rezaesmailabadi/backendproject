<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['image', 'order_id'];

    protected $casts = ['image' => 'array'];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
