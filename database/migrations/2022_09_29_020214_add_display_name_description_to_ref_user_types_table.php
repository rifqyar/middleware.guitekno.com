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
        Schema::table('ref_user_types', function (Blueprint $table) {
            //
            $table->string('ut_displayname')->nullable();
            $table->string('ut_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_user_types', function (Blueprint $table) {
            //
            $table->dropColumn('ut_displayname');
            $table->dropColumn('ut_desc');
        });
    }
};
