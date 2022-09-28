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
        Schema::create('log_callback', function (Blueprint $table) {
            $table->char('lcb_id', 15)->primary();
            $table->date('lcb_created');
            $table->string('lcb_create_by')->nullable();
            $table->date('lcb_last_updated')->nullable();
            $table->string('lcb_last_update_by')->nullable();
            $table->text('lcb_request');
            $table->string('lcb_response');
            $table->string('lcb_user_id')->nullable();
            $table->string('lcb_partnerid');
            $table->char('rst_id', 3);
            $table->foreign('rst_id')->references('rst_id')->on('ref_service_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_callback');
    }
};
