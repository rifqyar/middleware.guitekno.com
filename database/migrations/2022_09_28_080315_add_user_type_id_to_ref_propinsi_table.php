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
        Schema::table('ref_propinsi', function (Blueprint $table) {
            //
            $table->char('ut_id', 2)->nullable();
            $table->foreign('ut_id')->references('ut_id')->on('ref_user_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_propinsi', function (Blueprint $table) {
            //
            $table->dropColumn('ut_id');
        });
    }
};
