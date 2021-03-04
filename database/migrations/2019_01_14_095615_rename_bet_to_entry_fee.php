<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Transaction;

class RenameBetToEntryFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_instance_players', function ($table) {
            $table->renameColumn('bet_transaction_id', 'entry_fee_transaction_id');
        });

        Transaction::where('type', '=', 'bet')->update([
            'type' => 'entry_fee'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_instance_players', function ($table) {
            $table->renameColumn('entry_fee_transaction_id', 'bet_transaction_id');
        });

        Transaction::where('type', '=', 'entry_fee')->update([
            'type' => 'bet'
        ]);
    }
}
