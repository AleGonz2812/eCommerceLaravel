<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mostrar listado de todos los productos
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('category')
            ->paginate(12);
        
        return view('products.index', compact('products'));
    }

    /**
     * Mostrar un producto específico
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();
        
        // Productos relacionados de la misma categoría
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Buscar productos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('category')
            ->paginate(12);
        
        return view('products.index', compact('products', 'query'));
    }
}
