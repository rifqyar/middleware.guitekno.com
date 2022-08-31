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
        Schema::create('dat_bank_endpoint', function (Blueprint $table) {
            $table->increments('id');
            $table->char('dbs_id', 15);
            $table->string('dbe_endpoint');
            $table->char('ret_id', 15);
            $table->char('rrs_id', 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dat_bank_endpoint');
    }
};
