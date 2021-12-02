<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount')->default(0)->nullable();
            $table->integer('featured')->default(0)->nullable();
            $table->integer('capacity');
            $table->unsignedBigInteger('room_type_id');
            $table->foreign('room_type_id')
				->references('id')->on('room_types')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
