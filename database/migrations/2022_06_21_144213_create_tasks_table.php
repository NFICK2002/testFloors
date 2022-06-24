<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->date('date_end');
            $table->timestamps();
            $table->string('priority');
            $table->string('status');

            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id'
            )->references('id'
            )->on('users'
            )->cascadeOnDelete(
            )->cascadeOnUpdate();

            $table->unsignedBigInteger('responsible_id');
            $table->foreign('responsible_id'
            )->references('id'
            )->on('users'
            )->cascadeOnDelete(
            )->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
