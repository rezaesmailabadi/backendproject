<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;





class Order extends Model implements CanVisit
{
<<<<<<< HEAD
   
    use HasFactory;
    use HasVisits;
   

// use CyrildeWit\EloquentViewable\InteractsWithViews;
// use CyrildeWit\EloquentViewable\Contracts\Viewable;

// class Order extends Model implements Viewable
// {
//     use InteractsWithViews;

//     use HasFactory, SoftDeletes;

=======

    use HasFactory, SoftDeletes;
>>>>>>> 38ff09f35353048d8d123821bf52c6687edd3769


    public function sluggable(): array
    {

        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }



    protected $casts = ['image' => 'array'];





<<<<<<< HEAD

    /**
     * Get the total page views of the article.
     *
     * @return int
     */



    protected $fillable = ['title', 'introduction', 'slug', 'image', 'status', 'tags', 'price', 'publishable', 'category_id', 'email', 'mobile', 'first_name', 'user_id', 'last_name', 'published_at'];
    public function user()

=======
    protected $fillable = ['title', 'introduction', 'min_price', 'max_price', 'category_id', 'user_id', 'image_one', 'image_two', 'image_three', 'urgent', 'nardeban'];
    public function user()
>>>>>>> 38ff09f35353048d8d123821bf52c6687edd3769
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
