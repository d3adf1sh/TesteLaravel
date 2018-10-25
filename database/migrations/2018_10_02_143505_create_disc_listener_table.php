<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscListenerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_listener', function (Blueprint $table) {
            $table->integer('disc_id')->unsigned();
            $table->foreign('disc_id')->references('id')->on('discs');
            $table->integer('listener_id')->unsigned();
            $table->foreign('listener_id')->references('id')->on('listeners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_listener');
    }
}
