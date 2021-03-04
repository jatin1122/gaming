<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomIdToGameInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_instances', function ($table) {
            $table->integer('room_id')->index();
            $table->renameColumn('amount', 'prize');
            $table->decimal('commission', 10, 2);
            $table->decimal('total', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_instances', function ($table) {
            $table->dropColumn('room_id');
            $table->renameColumn('prize', 'amount');
            $table->dropColumn('commission');
            $table->dropColumn('total');
        });
    }
}
