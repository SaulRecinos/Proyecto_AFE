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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoryId')->constrained('categories');
            $table->foreignId('supplierId')->constrained('suppliers');
            $table->string('sku', 50)->unique();
            $table->string('name', 255);
            $table->decimal('purchasePrice', 12, 2);
            $table->decimal('salePrice', 12, 2);
            $table->integer('currentStock')->default(0);
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('inventoryMovements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productId')->constrained('products');
            $table->foreignId('movementTypeId')->constrained('movementTypes');
            $table->integer('quantity');
            $table->string('reason', 255)->nullable();
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
        Schema::dropIfExists('inventoryMovements');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
