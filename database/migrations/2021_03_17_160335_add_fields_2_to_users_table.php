<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFields2ToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('linkedin_login')->after('remember_token')->nullable();
            $table->string('linkedin_password')->after('linkedin_login')->nullable();
            $table->string('linkedin_public_id')->after('linkedin_password')->nullable();
            $table->string('linkedin_entityUrn')->after('linkedin_public_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

        });
    }
}
