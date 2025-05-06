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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('intern_id');
            $table->enum('sender_type', ['admin', 'intern']);
            $table->text('message');
            $table->timestamps();
    
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('intern_id')->references('id')->on('interns')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
