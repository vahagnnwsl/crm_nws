<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');

            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('agents');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->unsignedBigInteger('developer_id')->nullable();
            $table->foreign('developer_id')->references('id')->on('developers');

            $table->unsignedBigInteger('team_lid_id')->nullable();
            $table->foreign('team_lid_id')->references('id')->on('developers');

            $table->unsignedBigInteger('expert_id')->nullable();
            $table->foreign('expert_id')->references('id')->on('developers');

            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('source')->nullable();
            $table->string('link')->nullable();
            $table->integer('budget')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
        });

        Schema::create('project_stacks', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->unsignedBigInteger('stack_id');
            $table->foreign('stack_id')->references('id')->on('stacks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
