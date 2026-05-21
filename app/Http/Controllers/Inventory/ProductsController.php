<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Concerns\ErpControllerHelpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    use ErpControllerHelpers;

    public function index(): View
    {
        $products = Product::query()
            ->with(['category', 'supplier'])
            ->orderBy('name')
            ->get();

        return view('inventory.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->where('isActive', true)->orderBy('name')->get();
        $suppliers = Supplier::query()->where('isActive', true)->orderBy('name')->get();

        return view('inventory.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
            'supplierId' => ['required', 'integer', 'exists:suppliers,id'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'purchasePrice' => ['required', 'numeric', 'min:0'],
            'salePrice' => ['required', 'numeric', 'min:0'],
            'currentStock' => ['required', 'integer', 'min:0'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $product = Product::create($this->withAuditOnCreate([
            'categoryId' => $validated['categoryId'],
            'supplierId' => $validated['supplierId'],
            'sku' => $validated['sku'],
            'name' => $validated['name'],
            'purchasePrice' => $validated['purchasePrice'],
            'salePrice' => $validated['salePrice'],
            'currentStock' => $validated['currentStock'],
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logInsert($product, 'products');

        return redirect()->route('inventory.products.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('name')->get();
        $suppliers = Supplier::query()->orderBy('name')->get();

        return view('inventory.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
            'supplierId' => ['required', 'integer', 'exists:suppliers,id'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,'.$product->id],
            'name' => ['required', 'string', 'max:255'],
            'purchasePrice' => ['required', 'numeric', 'min:0'],
            'salePrice' => ['required', 'numeric', 'min:0'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $old = $product->toArray();
        $product->update($this->withAuditOnUpdate([
            'categoryId' => $validated['categoryId'],
            'supplierId' => $validated['supplierId'],
            'sku' => $validated['sku'],
            'name' => $validated['name'],
            'purchasePrice' => $validated['purchasePrice'],
            'salePrice' => $validated['salePrice'],
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logUpdate($product, 'products', $old);

        return redirect()->route('inventory.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->inventoryMovements()->exists()) {
            return redirect()->route('inventory.products.index')
                ->with('error', 'No se puede eliminar: el producto tiene movimientos de inventario.');
        }


        AuditService::logDelete($product, 'products');
        $product->delete();

        return redirect()->route('inventory.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
