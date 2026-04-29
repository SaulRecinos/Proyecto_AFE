<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RolesController extends Controller
{
    public function index(): View
    {
        $roles = Roles::query()
            ->with([
                'users' => function ($query) {
                    $query->select('id', 'name', 'roleId');
                },
                'permissions' => function ($query) {
                    $query->select('permissions.id', 'permissions.name');
                },
            ])
            ->orderBy('name')
            ->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permissions::query()->where('isActive', true)->orderBy('name')->get();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'code' => ['required', 'string', 'max:10', 'unique:roles,code'],
            'isActive' => ['required', 'in:0,1'],
            'permission_ids' => ['nullable', 'array'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
        ]);

        $actor = auth()->id() ?? 1;

        $role = Roles::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'isActive' => (bool) (int) $validated['isActive'],
            'createdBy' => $actor,
            'updatedBy' => $actor,
        ]);

        $role->permissions()->sync($validated['permission_ids'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Roles $role): View
    {
        $permissions = Permissions::query()->where('isActive', true)->orderBy('name')->get();
        $role->load('permissions');
        $selectedPermissionIds = $role->permissions->pluck('id')->all();

        return view('admin.roles.edit', compact('role', 'permissions', 'selectedPermissionIds'));
    }

    public function update(Request $request, Roles $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'code' => ['required', 'string', 'max:10', 'unique:roles,code,'.$role->id],
            'isActive' => ['required', 'in:0,1'],
            'permission_ids' => ['nullable', 'array'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
        ]);

        $actor = auth()->id() ?? 1;

        $role->update([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'isActive' => (bool) (int) $validated['isActive'],
            'updatedBy' => $actor,
        ]);

        $role->permissions()->sync($validated['permission_ids'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Roles $role): RedirectResponse
    {
        if ($role->users()->exists()) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'No se puede eliminar el rol porque tiene usuarios asignados.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
