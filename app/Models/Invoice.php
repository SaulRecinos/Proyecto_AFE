<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $table = 'invoices';

    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = 'updatedAt';

    /** @var list<string> */
    protected $fillable = [
        'customerId',
        'sellerId',
        'paymentStatusId',
        'paymentMethodId',
        'invoiceNumber',
        'issueDate',
        'totalAmount',
        'isActive',
        'createdBy',
        'updatedBy',
    ];

    protected function casts(): array
    {
        return [
            'isActive' => 'boolean',
            'issueDate' => 'datetime',
            'totalAmount' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sellerId');
    }

    public function paymentStatus(): BelongsTo
    {
        return $this->belongsTo(PaymentStatuses::class, 'paymentStatusId');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethods::class, 'paymentMethodId');
    }

    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoiceId');
    }
}
