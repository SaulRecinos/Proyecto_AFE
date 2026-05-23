<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\MovementTypes;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InventoryService
{
    public static function applyMovement(InventoryMovement $movement): void
    {
        $movement->loadMissing(['product', 'movementType']);
        $product = $movement->product;
        $code = $movement->movementType->code;

        DB::transaction(function () use ($movement, $product, $code) {
            $locked = Product::query()->lockForUpdate()->findOrFail($product->id);
            $qty = (int) $movement->quantity;

            if ($qty <= 0) {
                throw new InvalidArgumentException('La cantidad debe ser mayor a cero.');
            }

            $newStock = match ($code) {
                'IN', 'RET' => $locked->currentStock + $qty,
                'OUT' => $locked->currentStock - $qty,
                'ADJ' => $qty,
                default => throw new InvalidArgumentException('Tipo de movimiento no soportado.'),
            };

            if ($code === 'OUT' && $newStock < 0) {
                throw new InvalidArgumentException('Stock insuficiente para este producto.');
            }

            if ($newStock < 0) {
                throw new InvalidArgumentException('El stock resultante no puede ser negativo.');
            }

            $locked->update(['currentStock' => $newStock, 'updatedBy' => $movement->updatedBy ?? $movement->createdBy]);
        });
    }

    public static function reverseMovement(InventoryMovement $movement): void
    {
        $movement->loadMissing(['product', 'movementType']);
        $code = $movement->movementType->code;
        $qty = (int) $movement->quantity;

        DB::transaction(function () use ($movement, $code, $qty) {
            $locked = Product::query()->lockForUpdate()->findOrFail($movement->productId);

            $newStock = match ($code) {
                'IN', 'RET' => $locked->currentStock - $qty,
                'OUT' => $locked->currentStock + $qty,
                'ADJ' => throw new InvalidArgumentException('No se puede revertir un ajuste automáticamente.'),
                default => $locked->currentStock,
            };

            if ($newStock < 0) {
                throw new InvalidArgumentException('No se puede revertir el movimiento: stock insuficiente.');
            }

            $locked->update(['currentStock' => $newStock, 'updatedBy' => auth()->id() ?? 1]);
        });
    }

    public static function outTypeId(): int
    {
        return MovementTypes::query()->where('code', 'OUT')->value('id')
            ?? throw new InvalidArgumentException('Configure el tipo de movimiento OUT en catálogos.');
    }
}
