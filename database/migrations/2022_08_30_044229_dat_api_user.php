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
        Schema::create('dat_apiuser', function (Blueprint $table) {
            $table->char('bank_id', 3)->primary();
            $table->string('dau_username');
            $table->string('dau_password');
            $table->foreign('bank_id')->references('bank_id')->on('ref_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dat_apiuser');
    }
};
