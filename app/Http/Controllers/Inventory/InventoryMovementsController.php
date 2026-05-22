<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Concerns\ErpControllerHelpers;
use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\MovementTypes;
use App\Models\Product;
use App\Services\AuditService;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class InventoryMovementsController extends Controller
{
    use ErpControllerHelpers;

    public function index(): View
    {
        $movements = InventoryMovement::query()
            ->with(['product', 'movementType'])
            ->orderByDesc('createdAt')
            ->get();

        return view('inventory.movements.index', compact('movements'));
    }

    public function create(Request $request): View
    {
        $products = Product::query()->where('isActive', true)->orderBy('name')->get();
        $movementTypes = MovementTypes::query()->where('isActive', true)->orderBy('name')->get();
        $selectedProductId = $request->integer('productId') ?: null;

        return view('inventory.movements.create', compact('products', 'movementTypes', 'selectedProductId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'productId' => ['required', 'integer', 'exists:products,id'],
            'movementTypeId' => ['required', 'integer', 'exists:movementTypes,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $movement = InventoryMovement::create($this->withAuditOnCreate([
                'productId' => $validated['productId'],
                'movementTypeId' => $validated['movementTypeId'],
                'quantity' => $validated['quantity'],
                'reason' => $validated['reason'] ?: null,
                'isActive' => true,
            ]));

            InventoryService::applyMovement($movement);
            AuditService::logInsert($movement, 'inventoryMovements');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('inventory.movements.index')->with('success', 'Movimiento registrado y stock actualizado.');
    }

    public function destroy(InventoryMovement $movement): RedirectResponse
    {
        try {
            InventoryService::reverseMovement($movement);
            AuditService::logDelete($movement, 'inventoryMovements');
            $movement->delete();
        } catch (InvalidArgumentException $e) {
            return redirect()->route('inventory.movements.index')->with('error', $e->getMessage());
        }

        return redirect()->route('inventory.movements.index')->with('success', 'Movimiento eliminado y stock revertido.');
    }
}
