<?php

use App\GameInstance;
use App\Transaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGameIdAndUniqueConstraintToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('game_instance_id')->nullable();

            $table->unique(['game_instance_id', 'type', 'user_id'], 'unique_transactions');
        });

        $wonGames = GameInstance::whereNotNull('win_transaction_id')->get();

        foreach ($wonGames as $game) {
            $transaction = Transaction::find($game->win_transaction_id);

            if (! $transaction) {
                continue;
            }

            $transaction->game_instance_id = $game->id;

            $transaction->save();
        }

        $allPlayers = \DB::table('game_instance_players')->get();

        foreach ($allPlayers as $player) {
            $transaction = Transaction::find($player->entry_fee_transaction_id);

            if (empty($transaction)) {
                continue;
            }

            $transaction->game_instance_id = $player->game_instance_id;

            $transaction->save();
        }

        Schema::table('game_instances', function (Blueprint $table) {
            $table->dropColumn('win_transaction_id');
        });

        Schema::table('game_instance_players', function (Blueprint $table) {
            $table->dropColumn('entry_fee_transaction_id');
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
            $table->bigInteger('win_transaction_id')->nullable();
        });

        Schema::table('game_instance_players', function (Blueprint $table) {
            $table->bigInteger('entry_fee_transaction_id');
        });

        $winTransactions = Transaction::where('type', '=', 'win')->get();

        foreach ($winTransactions as $transaction) {
            $game = GameInstance::find($transaction->game_instance_id);

            if (! $game) {
                continue;
            }

            $game->win_transaction_id = $transaction->id;

            $game->save();
        }


        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique('unique_transactions');

            $table->dropColumn('game_instance_id');
        });
    }
}
