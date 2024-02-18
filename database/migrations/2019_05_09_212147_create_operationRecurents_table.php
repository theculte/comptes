<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOperationRecurentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operationRecurents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('detail')->nullable();
            $table->string('findme')->nullable();
            $table->date('date_start')->nullable();
            $table->string('every')->nullable();
            $table->boolean('checked')->default(0);
            $table->date('last_reboot')->nullable();
            $table->float('amount')->nullable();
            $table->integer('amount_delta')->nullable();
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
        Schema::drop('operationRecurents');
    }
}
