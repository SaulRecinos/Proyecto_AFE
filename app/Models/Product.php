<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = 'updatedAt';

    /** @var list<string> */
    protected $fillable = [
        'categoryId',
        'supplierId',
        'sku',
        'name',
        'purchasePrice',
        'salePrice',
        'currentStock',
        'isActive',
        'createdBy',
        'updatedBy',
    ];

    protected function casts(): array
    {
        return [
            'isActive' => 'boolean',
            'purchasePrice' => 'decimal:2',
            'salePrice' => 'decimal:2',
            'currentStock' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplierId');
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'productId');
    }
}
