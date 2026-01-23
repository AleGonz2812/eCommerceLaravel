<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Mostrar productos de una categoría específica
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = $category->products()
            ->paginate(12);
        
        return view('category.show', compact('category', 'products'));
    }
}
