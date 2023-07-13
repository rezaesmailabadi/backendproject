<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();


           
            $table->string('title');
            $table->text('introduction');
            $table->string('slug')->unique()->nullable();
            $table->text('image');
        
            $table->decimal('price', 20, 3);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('publishable')->default(1)->comment('1 => publishable, 0 => is not publishable');
            $table->string('tags');
            
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
           
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            
            
            
            $table->timestamp('published_at');
            $table->timestamps();
            $table->softDeletes();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
