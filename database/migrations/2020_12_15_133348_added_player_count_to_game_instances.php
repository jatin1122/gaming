<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedPlayerCountToGameInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_instances', function (Blueprint $table) {
            $table->Integer('player_count')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_instances', function (Blueprint $table) {
            $table->dropColumn('player_count');
        });
    }
}
