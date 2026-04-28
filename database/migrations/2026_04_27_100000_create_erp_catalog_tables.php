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
        Schema::create('customerTypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('movementTypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('paymentStatuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('paymentMethods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('auditActions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('code', 10)->unique();
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditActions');
        Schema::dropIfExists('paymentMethods');
        Schema::dropIfExists('paymentStatuses');
        Schema::dropIfExists('movementTypes');
        Schema::dropIfExists('customerTypes');
    }
};
