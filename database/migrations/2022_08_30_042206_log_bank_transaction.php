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
        Schema::create('log_bank_transaction', function (Blueprint $table) {
            $table->char('lbt_id', 15)->primary();
            $table->date('lbt_created');
            $table->string('lbt_create_by')->nullable();
            $table->date('lbt_last_updated')->nullable();
            $table->string('lbt_last_update_by')->nullable();
            $table->text('lbt_request')->nullable();
            $table->text('lbt_response')->nullable();
            $table->string('lbt_userid')->nullable();
            $table->char('rst_id', 3);
            $table->string('lbt_acc_number', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_bank_transaction');
    }
};
