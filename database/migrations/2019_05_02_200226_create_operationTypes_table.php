<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOperationTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operationTypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('id_category')->nullable();
            $table->string('findme')->nullable();
            $table->string('icon')->nullable();
            $table->string('tags')->nullable();
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
        Schema::drop('operationTypes');
    }
}
