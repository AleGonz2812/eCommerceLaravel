<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio
     * Las categorías se comparten vía ViewComposer
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Si es administrador, redirigir al panel de administración
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.products.index');
        }
        
        // Obtener productos destacados (máximo 8)
        $featuredProducts = Product::where('featured', true)
            ->with('category')
            ->limit(8)
            ->get();
        
        // Total de productos
        $totalProducts = Product::count();
        
        return view('home', compact('featuredProducts', 'totalProducts'));
    }
}
