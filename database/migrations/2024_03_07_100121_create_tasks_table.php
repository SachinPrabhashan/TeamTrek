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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('isCompleted')->nullable()->default(false);
            $table->text('Description');
            $table->integer('dev_hours')->nullable();
            $table->integer('eng_hours')->nullable();
            $table->timestamps();

            $table->boolean('isDelete')->nullable()->default(false);
            $table->boolean('isUpdate')->nullable()->default(false);

            $table->foreign('support_contract_instance_id')->references('id')->on('support_contract_instances');
            $table->foreign('user_id')->references('id')->on('users');
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
