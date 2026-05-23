<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetail extends Model
{
    protected $table = 'invoiceDetails';

    public $timestamps = false;

    /** @var list<string> */
    protected $fillable = [
        'invoiceId',
        'productId',
        'quantity',
        'unitPrice',
        'lineTotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unitPrice' => 'decimal:2',
            'lineTotal' => 'decimal:2',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoiceId');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
