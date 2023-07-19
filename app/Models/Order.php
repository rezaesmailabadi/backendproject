<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model

{

    use HasFactory, SoftDeletes;


    public function sluggable(): array
    {

        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }



    protected $casts = ['image' => 'array'];





    protected $fillable = ['title', 'introduction', 'min_price', 'max_price', 'category_id', 'user_id', 'image_one', 'image_two', 'image_three', 'urgent', 'nardeban'];
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(OrderImage::class);
    }
}
