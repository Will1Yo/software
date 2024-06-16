<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collaborators;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('login.login', ['view' => 'login']);
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user_data = User::select('id', 'name')
            ->where('email', $request->email)
            ->first();
            
            // Encontrar la posición del primer espacio
            $pos = strpos($user_data->name, ' ');

            // Verificar si se encontró un espacio
            if ($pos !== false) {
                // Obtener la subcadena desde el inicio hasta el primer espacio
                $result = substr($user_data->name, 0, $pos);
            } else {
                // Si no hay espacio, devolver la cadena completa
                $result = $user_data->name;
            }
           
            $request->session()->put([
                'user_id' => $user_data->id,
                'user_complete' => $user_data->name,
                'user_email' => $request->email,
                'user_name' => $result,
            ]);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
