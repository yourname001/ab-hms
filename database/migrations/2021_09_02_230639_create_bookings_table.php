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
            $table->string('type_of_identification')->nullable();
            $table->string('proof_of_identity')->nullable();
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
            $table->timestamp('booking_date_from')->nullable();
            $table->timestamp('booking_date_to')->nullable();
            $table->integer('amount')->default(0)->nullable();
            $table->enum('payment_status', ['unpaid', 'partial', 'paid']);
            $table->enum('booking_status', ['pending', 'reserved', 'confirmed', 'checked in', 'checked out', 'canceled', 'expired', 'declined']);
            $table->string('reason_of_cancellation')->nullable();
            $table->string('other_reasons')->nullable();
            $table->string('decline_reason')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
