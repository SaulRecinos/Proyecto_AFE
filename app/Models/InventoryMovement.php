<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $table = 'inventoryMovements';

    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = 'updatedAt';

    /** @var list<string> */
    protected $fillable = [
        'productId',
        'movementTypeId',
        'quantity',
        'reason',
        'isActive',
        'createdBy',
        'updatedBy',
    ];

    protected function casts(): array
    {
        return [
            'isActive' => 'boolean',
            'quantity' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    public function movementType(): BelongsTo
    {
        return $this->belongsTo(MovementTypes::class, 'movementTypeId');
    }
}
