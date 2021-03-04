<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedTypeToPhlyoTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phylo_transactions', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phylo_transactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}