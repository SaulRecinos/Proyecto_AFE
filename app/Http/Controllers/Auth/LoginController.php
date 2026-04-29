<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario (un solo botón; aún no se valida email/contraseña).
     */
    public function create(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Inicia sesión como el usuario administrador de seed (o el primero en BD).
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::query()
            ->where('email', 'admin@proyectoafe.com')
            ->first()
            ?? User::query()->orderBy('id')->first();

        if ($user === null) {
            return back()->with('error', 'No hay usuarios. Ejecuta: php artisan db:seed --class=AdminModuleSeeder');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
