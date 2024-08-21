<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatamitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datamita', function (Blueprint $table) {
            $table->id();
            $table->string('MaChamCong');
            $table->dateTime('NgayCham');
            $table->dateTime('GioCham');
            $table->tinyInteger('KieuCham');
            $table->integer('NguonCham');
            $table->integer('MaSoMay');
            $table->string('TenMay');
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
        Schema::dropIfExists('datamita');
    }
}
