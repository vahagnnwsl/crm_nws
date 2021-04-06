<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedinConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linkedin_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('entityUrn');
            $table->integer('unreadCount')->nullable();
            $table->json('data');
            $table->date('lastActivityAt')->nullable();
            $table->timestamps();
        });

        Schema::create('linkedin_conversation_users', function (Blueprint $table) {

            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->foreign('conversation_id')->references('id')->on('linkedin_conversations')->onDelete('cascade');


            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linkedin_conversations');
    }
}
