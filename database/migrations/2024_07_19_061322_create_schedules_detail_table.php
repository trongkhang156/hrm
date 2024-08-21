<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules_detail', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing primary key column named 'id'
            $table->unsignedBigInteger('idcong'); // 'idcong' column of type UNSIGNED BIG INTEGER
            $table->unsignedBigInteger('id_ca'); // 'id_ca' column of type UNSIGNED BIG INTEGER
            $table->time('starttime'); // 'starttime' column of type TIME
            $table->time('endtime'); // 'endtime' column of type TIME
            $table->boolean('isthrough_newday')->default(false); // 'isthrough_newday' column of type BOOLEAN with default value
            $table->boolean('isdelete')->default(false); // 'isdelete' column of type BOOLEAN with default value
            $table->timestamps(); // 'created_at' and 'updated_at' columns

            // Define the foreign key constraint
            $table->foreign('id_ca')->references('id')->on('schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules_detail', function (Blueprint $table) {
            // Drop the foreign key constraint before dropping the column
            $table->dropForeign(['id_ca']);
        });

        Schema::dropIfExists('schedules_detail');
    }
}
