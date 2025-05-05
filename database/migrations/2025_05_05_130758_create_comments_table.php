<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intern_id');
            $table->string('type'); // 'admin' or 'intern'
            $table->unsignedBigInteger('task_id');
            $table->text('content');
            $table->timestamps();

            // Foreign key to tasks table
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
