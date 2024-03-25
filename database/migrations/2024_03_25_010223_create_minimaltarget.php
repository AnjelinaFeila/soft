<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('minimaltarget', function (Blueprint $table) {
            $table->increments('id_minimaltarget');
            $table->integer('id_material')->nullable(false);
            $table->integer('id_proses')->nullable(false);
            $table->integer('minimal_target')->nullable(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('minimaltarget');
    }
};
