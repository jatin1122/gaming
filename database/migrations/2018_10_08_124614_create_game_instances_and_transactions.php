<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameInstancesAndTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id');
            $table->string('type')->default('deposit');
            $table->decimal('amount', 10, 2)->index();

            $table->timestamps();
        });

        Schema::create('game_instances', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('game_id');
            $table->bigInteger('win_transaction_id')->nullable();
            $table->decimal('amount', 10, 2)->index();
            $table->string('state')->default('in_progress');

            $table->timestamps();
        });

        Schema::create('game_instance_players', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('game_instance_id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('bet_transaction_id')->index();
            $table->boolean('winner')->default(false);

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
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('game_instances');
        Schema::dropIfExists('game_instance_players');
    }
}
