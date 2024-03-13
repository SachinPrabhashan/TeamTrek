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
        Schema::create('support_contract_instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_contract_id');
            $table->timestamps();
            $table->integer('year');
            $table->string('owner');
            $table->double('dev_hours');
            $table->double('eng_hours');

            $table->boolean('isDelete')->nullable()->default(false);
            $table->boolean('isUpdate')->nullable()->default(false);

            $table->foreign('support_contract_id')->references('id')->on('support_contracts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_contract_instances');
    }
};
