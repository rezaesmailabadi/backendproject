<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->nullable();//نام کاربری
            $table->string('country')->unique()->nullable();//کشور
            $table->string('city')->unique()->nullable();//شهر
            $table->string('proficiency')->nullable();//مهارت ها
            $table->longText('work_samples')->nullable();//نمونه کار
            $table->string('educational_records')->nullable();//سوابق تحصیلی
            $table->string('achievement')->nullable();//دستاورد
            $table->string('other_information')->nullable();//سایر اطلاعات
            $table->string('work_resume')->nullable();//سوابق کاری
            $table->string('title')->unique()->nullable();//عنوان و سمت
            $table->longText('profile_photo_path')->nullable()->comment('avatar');//عکس پروفای
            $table->tinyInteger('role')->default(0)->comment('0 => freelancer , 1=> employer');//نقش کاربر کارفرما یا فریلنسر
            $table->tinyInteger('Holidays')->default(0)->comment('0 => active , 1=> notactive');//حالت تعطیلات
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resumes');
    }
}
