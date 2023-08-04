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
            $table->string('urgent')->default('false');
            $table->string('nardeban')->default('false');
            $table->longText('image_one')->nullable();
            $table->longText('image_two')->nullable();
            $table->longText('image_three')->nullable();
            $table->integer('min_price');
            $table->integer('max_price');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('publishable')->default(0)->comment('1 => publishable, 0 => is not publishable');
            $table->string('tags')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('token');



            $table->foreignId('category_id')->nullable()->constrained('categories')->onUpdate('cascade')->onDelete('cascade');

            $table->string('delivery_date');


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
