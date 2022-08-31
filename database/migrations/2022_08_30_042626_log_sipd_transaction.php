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
        Schema::create('log_sipd_transaction', function (Blueprint $table) {
            $table->char('lst_id', 15)->primary();
            $table->string('lst_sipd_tx_id', 32);
            $table->string('lst_bpd_tx_id', 32);
            $table->date('lst_created');
            $table->string('lst_create_by')->nullable();
            $table->date('lst_last_updated')->nullable();
            $table->string('lst_last_update_by')->nullable();
            $table->text('lst_request')->nullable();
            $table->text('lst_response')->nullable();
            $table->string('lst_userid')->nullable();
            $table->char('rst_id', 3);
            $table->char('ras_id', 3)->nullable();
            $table->string('lst_acc_number', 20)->nullable();
            $table->string('ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_sipd_transaction');
    }
};
