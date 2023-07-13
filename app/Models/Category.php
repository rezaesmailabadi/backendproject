<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'name'
            ]
        ];
    }

    

    protected $casts = ['image' => 'array'];



    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'tags'];
   
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'category_id');
    }
    

}
