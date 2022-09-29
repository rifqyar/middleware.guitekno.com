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
        Schema::create('dat_partnertoken', function (Blueprint $table) {
            $table->increments('dpt_id');
            $table->date('dpt_created')->nullable();
            $table->string('dpt_partnerid', 32);
            $table->string('dpt_token', 256);
            $table->integer('dpt_isexpired');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('dat_partnertoken');
    }
};
