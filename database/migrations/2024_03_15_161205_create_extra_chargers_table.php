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
        Schema::create('extra_chargers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_task_id')->nullable();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('support_contract_instance_id');
            $table->integer('charging_dev_hours');
            $table->integer('charging_eng_hours');
            $table->integer('chargers_for_dev_hours');
            $table->integer('chargers_for_eng_hours');
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('sub_task_id')->references('id')->on('sub_tasks');
            $table->foreign('support_contract_instance_id')->references('id')->on('support_contract_instances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_chargers');
    }
};
