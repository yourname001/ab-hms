<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')
				->references('id')->on('rooms')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->date('booking_date');
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
        Schema::dropIfExists('bookings');
    }
}
