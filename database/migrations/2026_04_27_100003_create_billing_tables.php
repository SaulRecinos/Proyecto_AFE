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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customerId')->constrained('customers');
            $table->foreignId('sellerId')->constrained('users');
            $table->foreignId('paymentStatusId')->constrained('paymentStatuses');
            $table->foreignId('paymentMethodId')->constrained('paymentMethods');
            $table->string('invoiceNumber', 50)->unique();
            $table->dateTime('issueDate');
            $table->decimal('totalAmount', 12, 2);
            $table->boolean('isActive')->default(true);
            $table->timestamp('createdAt')->useCurrent();
            $table->unsignedBigInteger('createdBy');
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updatedBy')->nullable();
        });

        Schema::create('invoiceDetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoiceId')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('productId')->constrained('products');
            $table->integer('quantity');
            $table->decimal('unitPrice', 12, 2);
            $table->decimal('lineTotal', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoiceDetails');
        Schema::dropIfExists('invoices');
    }
};
