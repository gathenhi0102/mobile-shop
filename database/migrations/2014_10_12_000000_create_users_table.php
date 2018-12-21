<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->string('password', 191);
			$table->text('user_image')->nullable();
			$table->tinyInteger('user_level')->default(0);
			$table->text('phone');
			$table->text('address')->nullable();
			$table->tinyInteger('type')->default(1);
			$table->tinyInteger('gender')->nullable();
			$table->bigInteger('point')->default(0);
			$table->timestamp('last_login_timestamp')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
