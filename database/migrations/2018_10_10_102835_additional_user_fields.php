<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob')->default('1970-01-01');
            $table->char('country', 2)->default('GB');
            $table->string('username');
            $table->dropColumn('name');
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
            $table->dropColumn('title');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('dob');
            $table->dropColumn('username');
            $table->string('name');
        });
    }
}
