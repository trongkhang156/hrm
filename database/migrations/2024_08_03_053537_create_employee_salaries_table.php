<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('id_config')->constrained('config_salaries')->onDelete('cascade'); // Foreign key linking to config_salaries
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Foreign key linking to employees
            $table->timestamps(); // Created at and updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_salaries');
    }
}

