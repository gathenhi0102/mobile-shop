<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('category_id');
            $table->integer('trademark_id');
            $table->integer('original_price');
            $table->integer('quantity');
            $table->integer('view_count')->default(0);
            $table->integer('buy_count')->default(0);
            $table->text('description')->nullable();
            $table->text('parameters');
            $table->text('main_image');
            $table->text('gift')->nullable();
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
        //
        Schema::dropIfExists('product');
    }
}
