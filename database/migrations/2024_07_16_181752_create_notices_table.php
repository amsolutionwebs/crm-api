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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
        $table->foreign('admin_id')
              ->references('id')
              ->on('admins')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        $table->string('category')->nullable();
        $table->string('notice_title')->nullable();
        $table->string('notice_image')->nullable();
        $table->string('url')->nullable();
        $table->timestamp('start_date')->nullable();
        $table->timestamp('end_date')->nullable(); // Make end_date nullable
        $table->string('status')->nullable();      
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
