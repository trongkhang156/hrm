<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftscheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiftschedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_employees')->constrained('employees')->onDelete('cascade'); // Adjust the table name if different
            $table->foreignId('id_ca')->constrained('schedules')->onDelete('cascade');
            $table->date('shift_date');
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
        Schema::dropIfExists('shiftschedule');
    }
}
