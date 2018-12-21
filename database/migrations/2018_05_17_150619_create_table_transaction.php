<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->default(0);
            $table->integer('status_id');
            $table->text('customer_name');
            $table->string('customer_email',191)->unique();
            $table->text('customer_phone');
            $table->text('delivery_address');
            $table->text('description')->nullable();
			$table->text('note')->nullable();
            $table->bigInteger('total_amount');
            $table->integer('transport_fee')->default(0);
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
        Schema::dropIfExists('transaction');
    }
}
