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
