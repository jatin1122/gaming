<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Group;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug')->unique();
            $table->json('permissions');

            $table->timestamps();
        });

        Schema::create('user_groups', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->foreign()->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('group_id')->unsigned()->foreign()->references('id')->on('groups')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });

        Group::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'nova'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('user_groups');
    }
}
