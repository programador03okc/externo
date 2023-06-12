<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function cerrarSesion()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
