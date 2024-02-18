<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOperationIncommingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operationIncommings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_operation_type')->nullable();
            $table->float('amount')->nullable();
            $table->float('amount_delta')->nullable();
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
        Schema::drop('operationIncommings');
    }
}
