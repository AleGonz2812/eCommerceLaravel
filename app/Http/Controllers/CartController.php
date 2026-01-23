<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Mostrar el carrito de compras
     * Temporal - Se implementará en NIVEL INTERMEDIO
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('home')
            ->with('info', 'El carrito se implementará próximamente');
    }
}
