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
        Schema::create('ref_bank', function (Blueprint $table) {
            $table->char('bank_id', 3)->primary();
            $table->string('bank_name');
            $table->char('rrs_id', 2);
            $table->foreign('rrs_id')->references('rrs_id')->on('ref_runstate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ref_bank');
    }
};
