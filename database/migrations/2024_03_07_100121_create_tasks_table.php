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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_contract_instance_id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('isCompleted')->nullable()->default(false);
            $table->text('Description');
            $table->timestamps();

            $table->foreign('support_contract_instance_id')->references('id')->on('support_contract_instances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};