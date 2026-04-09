<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'password.required' => 'A senha é obrigatória'
        ]);

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                $request->session()->regenerate();
                
                $mensagem = 'Bem-vindo(a) de volta, ' . Auth::user()->name . '!';
                if (Auth::user()->isAdmin()) {
                    $mensagem .= ' (Administrador)';
                }
                
                return redirect()->route('animais.index')->with('success', $mensagem);
            }

            return back()->withErrors([
                'email' => 'As credenciais informadas não são válidas.',
            ])->onlyInput('email');
            
        } catch (Exception $e) {
            Log::error('Erro no login: ' . $e->getMessage());
            return back()->with('error', 'Erro ao fazer login. Tente novamente.');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'required|string|max:20|unique:users,telefone',
            'password' => 'required|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está cadastrado',
            'telefone.required' => 'O telefone é obrigatório',
            'telefone.unique' => 'Este telefone já está cadastrado',
            'telefone.max' => 'Telefone deve ter no máximo 20 caracteres',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'As senhas não conferem'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'password' => Hash::make($request->password),
                'role' => 'CLI', // Padrão: cliente
            ]);

            Auth::login($user);

            return redirect()->route('animais.index')
                ->with('success', 'Cadastro realizado com sucesso! Bem-vindo(a) ao AdotaPet!');
                
        } catch (Exception $e) {
            Log::error('Erro no cadastro: ' . $e->getMessage());
            return back()->with('error', 'Erro ao realizar cadastro. Tente novamente.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Você saiu do sistema com sucesso!');
    }
}