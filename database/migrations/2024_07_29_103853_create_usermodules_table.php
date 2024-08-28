<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usermodules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')
              ->references('id')
              ->on('modules')
              ->onUpdate('cascade')
              ->onDelete('cascade');
            $table->string('employee_id')->nullable();
            $table->string('add')->nullable();
            $table->string('view')->nullable();
            $table->string('edit')->nullable();
            $table->string('delete')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usermodules');
    }
};
