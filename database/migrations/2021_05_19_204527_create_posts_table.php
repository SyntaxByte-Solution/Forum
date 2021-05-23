<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->longtext('content');
            $table->integer('report_count')->default('0');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('status_id')->default('1');
            $table->unsignedBigInteger('editor_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('thread_id')->references('id')->on('threads');
            $table->foreign('status_id')->references('id')->on('post_status');
            $table->foreign('editor_id')->references('id')->on('users');

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
        Schema::dropIfExists('posts');
    }
}
