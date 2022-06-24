<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('last_name');
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->unsignedBigInteger('boss_id')->nullable(true)->default(NULL);
            $table->foreign('boss_id'
            )->references('id'
            )->on('users'
            )->cascadeOnDelete(
            )->cascadeOnUpdate();

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
        Schema::dropIfExists('users');
    }
}
