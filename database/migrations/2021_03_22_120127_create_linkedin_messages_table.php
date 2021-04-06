<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedinMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linkedin_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->foreign('conversation_id')->references('id')->on('linkedin_conversations')->onDelete('cascade');
            $table->string('conversation_entityUrn');

            $table->string('user_entityUrn');

            $table->longText('text')->nullable();
            $table->json('media')->nullable();
            $table->json('attachments')->nullable();
            $table->string('entityUrn');
            $table->string('hash')->nullable();


            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('event')->default(0);
            $table->dateTime('date');

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
        Schema::dropIfExists('linkedin_messages');
    }
}
