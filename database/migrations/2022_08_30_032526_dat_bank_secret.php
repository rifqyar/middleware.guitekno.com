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
        Schema::create('dat_bank_secret', function (Blueprint $table) {
            $table->char('id', 15)->primary();
            $table->char('code_bank', 3);
            $table->string('client_id', 50);
            $table->string('client_secret', 250);
            $table->string('username', 50);
            $table->string('password', 20);
            $table->string('token', 250)->nullable();
            $table->string('expired_time')->nullable();
            $table->foreign('code_bank')->references('bank_id')->on('ref_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dat_bank_secret');
    }
};
