<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = User::query()->with('role')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Roles::query()->orderBy('name')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'roleId' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $actor = auth()->id() ?? 1;

        User::create([
            'roleId' => $validated['roleId'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'isActive' => (bool) (int) $validated['isActive'],
            'createdBy' => $actor,
            'updatedBy' => $actor,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        $roles = Roles::query()->orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'roleId' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Password::min(6)],
            'isActive' => ['required', 'in:0,1'],
        ]);

        $actor = auth()->id() ?? 1;

        $data = [
            'roleId' => $validated['roleId'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'isActive' => (bool) (int) $validated['isActive'],
            'updatedBy' => $actor,
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $actor = auth()->id();

        if ($actor && (int) $user->id === (int) $actor) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario desde este formulario.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
