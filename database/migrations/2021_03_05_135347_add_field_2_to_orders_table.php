<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddField2ToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('developer_id')->nullable()->after('creator_id');
            $table->foreign('developer_id')->references('id')->on('developers');

            $table->unsignedBigInteger('team_lid_id')->nullable()->after('developer_id');
            $table->foreign('team_lid_id')->references('id')->on('developers');


            $table->unsignedBigInteger('expert_id')->nullable()->after('team_lid_id');
            $table->foreign('expert_id')->references('id')->on('developers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
