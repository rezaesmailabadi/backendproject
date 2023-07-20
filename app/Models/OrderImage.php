<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    use HasFactory;
    protected $casts = ['image' => 'array'];
    //   نوع آرایه هست favorite  ز   توی کد بالا، گفتیم که از
    //   ، لاراول بطور خودکار قبل از ثبت اطلاعات،
    //   اونها رو از آرایه به رشته تبدیل می‌کنه و همچنین قبل از نمایش، اون رو به آرایه تبدیل می‌کنه
    
    
    
        // فیلدهایی که حتما باید در دیتابیس ذخیره شوند 
        
        protected $fillable = ['order_id', 'image'];
    
        public function ordersImage()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
