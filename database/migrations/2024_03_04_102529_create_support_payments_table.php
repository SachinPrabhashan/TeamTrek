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
        Schema::create('support_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_contract_instance_id');
            $table->integer('year');
            $table->double('dev_rate_per_hour');
            $table->double('eng_rate_per_hour');
            $table->timestamps();

            $table->boolean('isDelete')->nullable()->default(false);
            $table->boolean('isUpdate')->nullable()->default(false);

            $table->foreign('support_contract_instance_id')->references('id')->on('support_contract_instances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_payments');
    }
};
