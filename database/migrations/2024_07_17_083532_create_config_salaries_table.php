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
        Schema::create('config_salaries', function (Blueprint $table) {
            $table->id(); // Tạo cột 'id' và đặt làm primary key tự động
            $table->timestamps(); // Tự động thêm cột 'created_at' và 'updated_at'
            $table->integer('is_active')->nullable();
            $table->string('name', 200)->nullable()->collation('utf8mb4_unicode_ci');
            $table->integer('display_order')->nullable();
            $table->integer('type')->nullable();
            // Các cột khác nếu cần thiết
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('config_salaries');
    }
};
