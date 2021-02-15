<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id_take');
            $table->integer('user_id_send');
            $table->integer('chat_manager_id');
            $table->boolean('seen');
            $table->string('status','25')->default('NORMAL');
            $table->integer('attachment_id')->nullable();
            $table->longText('message');
            $table->timestamp('deleted_at')->nullable();
            $table->string('type',20)->default('TEXT');
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
        Schema::dropIfExists('chats');
    }
}
