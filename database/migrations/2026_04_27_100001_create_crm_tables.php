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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customerTypeId')->constrained('customerTypes');
            $table->string('fullName', 255);
            $table->string('taxId', 50)->nullable()->unique();
            $table->string('email', 255)->nullable();
            $table->string('phoneNumber', 20)->nullable();
            $table->text('address')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('taxId', 50)->nullable()->unique();
            $table->string('contactName', 255)->nullable();
            $table->string('phoneNumber', 20)->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('customers');
    }
};
