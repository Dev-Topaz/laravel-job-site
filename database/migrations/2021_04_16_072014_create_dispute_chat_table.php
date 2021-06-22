<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputeChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("request_id");
            $table->unsignedBigInteger("send_id");
            $table->unsignedBigInteger("receive_id");
            $table->text("content");
            $table->string("upload")->default('none');
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->foreign('send_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receive_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispute_chat');
    }
}
