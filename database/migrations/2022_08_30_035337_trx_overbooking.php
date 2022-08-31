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
        Schema::create('trx_overbooking', function (Blueprint $table) {
            $table->char('tbk_id', 15)->primary();
            $table->date('tbk_created');
            $table->string('tbk_create_by')->nullable();
            $table->date('tbk_last_updated')->nullable();
            $table->string('tbk_last_update_by')->nullable();
            $table->string('tbk_notes')->nullable();
            $table->char('tbk_partnerid', 32);
            $table->char('tbk_tx_id', 32);
            $table->double('tbk_amount', 15, 0);
            $table->string('tbk_userid')->nullable();
            $table->char('tbk_sender_bank_id', 3);
            $table->string('tbk_sender_account');
            $table->double('tbk_sender_amount', 15, 0);
            $table->char('tbk_recipient_bank_id', 3);
            $table->string('tbk_recipient_account');
            $table->double('tbk_recipient_amount', 15, 0);
            $table->string('tbk_internal_status')->nullable();
            $table->string('tbk_sp2d_no')->nullable();
            $table->string('tbk_sp2d_desc')->nullable();
            $table->string('tbk_execution_time')->nullable();
            $table->string('tbk_billing_id')->nullable();
            $table->string('tbk_ntpn')->nullable();
            $table->date('tbk_ntpn_date')->nullable();
            $table->string('tbk_ntb')->nullable();
            $table->string('tbk_type')->nullable();
            $table->char('ras_id', 3)->nullable();
            $table->foreign('ras_id')->references('ras_id')->on('ref_api_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trx_overbooking');
    }
};
