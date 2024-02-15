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
        Schema::create('role_mod_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_permission_id');
            $table->unsignedBigInteger('role_id');
            $table->boolean('isActive')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('module_permission_id')->references('id')->on('module_permissions');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_mod_permissions');
    }
};
