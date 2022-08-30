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
        Schema::create('dat_ipwhitelist', function (Blueprint $table) {
            $table->char('bank_id', 3)->primary();
            $table->decimal('diw_index', $precision = 2, $scale = 0);
            $table->string('diw_address');
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
        Schema::drop('dat_ipwhitelist');
    }
};
