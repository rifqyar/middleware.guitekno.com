<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_dati2', function (Blueprint $table) {
            $table->unsignedInteger('prop_id');
            $table->increments('dati2_id');
            $table->string('dati2_nama');
            $table->foreign('prop_id')->references('prop_id')->on('ref_propinsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ref_dati2');
    }
};