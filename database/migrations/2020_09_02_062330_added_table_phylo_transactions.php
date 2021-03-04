<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedTablePhyloTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phylo_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('order_id');
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('status');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('data')->nullable();
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
        Schema::dropIfExists('phylo_transactions');
    }
}