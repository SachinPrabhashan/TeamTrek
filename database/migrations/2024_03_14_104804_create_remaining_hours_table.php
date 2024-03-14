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
        Schema::create('remaining_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_task_id')->nullable();
            $table->unsignedBigInteger('task_id');
            $table->integer('rem_dev_hours');
            $table->integer('rem_eng_hours');
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('sub_task_id')->references('id')->on('sub_tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remaining_hours');
    }
};
