<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('email',191)->unique();
            $table->text('password');
            $table->text('phone');
            $table->text('address')->nullable();
            $table->string('type',191)->nullable();
            $table->string('gender',10)->nullable();
            $table->integer('point')->default(0);
            $table->timestamp('last_login_timestamp')->nullable();
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
        Schema::dropIfExists('customer');
    }
}
