<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolloptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polloptions', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->unsignedBigInteger('poll_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('poll_id')->references('id')->on('polls');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('polloptions');
    }
}
