<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($dados)) {
            $request->session()->regenerate();

            $perfil = Auth::user()->perfil;

            if ($perfil === 'administrador') {
                return redirect()->route('dashboard');
            }

            if ($perfil === 'operador') {
                return redirect()->route('gestao.denuncias.index');
            }

            return redirect()->route('acompanhamento.index');
        }

        return back()
            ->withErrors([
                'email' => 'E-mail ou palavra-passe incorrectos.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('sucesso', 'Sessão terminada com sucesso.');
    }
}
