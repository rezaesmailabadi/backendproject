<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;





class Order extends Model implements CanVisit
{
   
    use HasFactory;
    use HasVisits;
   

// use CyrildeWit\EloquentViewable\InteractsWithViews;
// use CyrildeWit\EloquentViewable\Contracts\Viewable;

// class Order extends Model implements Viewable
// {
//     use InteractsWithViews;

//     use HasFactory, SoftDeletes;


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






    /**
     * Get the total page views of the article.
     *
     * @return int
     */



    // protected $fillable = ['title', 'introduction', 'slug', 'image', 'status', 'tags', 'price', 'publishable', 'category_id', 'email', 'mobile', 'first_name', 'user_id', 'last_name', 'published_at'];
    // public function user()

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
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
