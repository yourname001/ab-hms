<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('proof_of_payment')->nullable();
            $table->enum('payment_status', ['pending', 'confirmed', 'denied']);
            $table->enum('mode_of_payment', ['gcash', 'cash']);
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('amount')->default(0)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
