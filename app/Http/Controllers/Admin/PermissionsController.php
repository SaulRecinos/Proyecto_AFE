<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permissions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionsController extends Controller
{
    public function index(): View
    {
        $permissions = Permissions::query()->orderBy('name')->get();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'code' => ['required', 'string', 'max:50', 'unique:permissions,code'],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $actor = auth()->id() ?? 1;

        Permissions::create([
            'name' => $validated['name'],
            'code' => mb_strtoupper($validated['code']),
            'isActive' => (bool) (int) $validated['isActive'],
            'createdBy' => $actor,
            'updatedBy' => $actor,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permiso creado correctamente.');
    }

    public function edit(Permissions $permission): View
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permissions $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'code' => ['required', 'string', 'max:50', 'unique:permissions,code,'.$permission->id],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $actor = auth()->id() ?? 1;

        $permission->update([
            'name' => $validated['name'],
            'code' => mb_strtoupper($validated['code']),
            'isActive' => (bool) (int) $validated['isActive'],
            'updatedBy' => $actor,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permissions $permission): RedirectResponse
    {
        if ($permission->roles()->exists()) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'No se puede eliminar el permiso porque está asignado a uno o más roles.');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permiso eliminado correctamente.');
    }
}
