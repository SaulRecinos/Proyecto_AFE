<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Concerns\ErpControllerHelpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    use ErpControllerHelpers;

    public function index(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('inventory.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('inventory.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $category = Category::create($this->withAuditOnCreate([
            'name' => $validated['name'],
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logInsert($category, 'categories');

        return redirect()->route('inventory.categories.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Category $category): View
    {
        return view('inventory.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $old = $category->toArray();
        $category->update($this->withAuditOnUpdate([
            'name' => $validated['name'],
            'isActive' => (bool) (int) $validated['isActive'],
        ]));

        AuditService::logUpdate($category, 'categories', $old);

        return redirect()->route('inventory.categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()->route('inventory.categories.index')
                ->with('error', 'No se puede eliminar: la categoría tiene productos asociados.');
        }

        AuditService::logDelete($category, 'categories');
        $category->delete();

        return redirect()->route('inventory.categories.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
