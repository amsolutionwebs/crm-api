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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
              ->references('id')
              ->on('customers')
              ->onUpdate('cascade')
              ->onDelete('cascade');
              $table->string('project_name')->nullable();
              $table->string('price')->nullable();
              $table->string('deadline')->nullable();
              $table->string('requirement_type')->nullable();
              $table->string('requirement')->nullable();
              $table->string('refferal_website')->nullable();
              $table->string('refferal_app')->nullable();
              $table->string('screenshot')->nullable();
              $table->string('project_status')->nullable();
              $table->string('status')->nullable();
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
