<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra la lista de todos los productos para el admin
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los productos con sus categorías
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo producto
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtener todas las categorías para el select
        $categories = Category::all();
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * Guarda el nuevo producto en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
        ]);

        // Generar el slug automáticamente desde el nombre
        $validated['slug'] = Str::slug($validated['name']);

        // Subir la imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Crear el producto
        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     * No lo usaremos en este proyecto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // No implementado - usamos la vista de productos normal
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar un producto existente
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza el producto en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validar los datos
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
        ]);

        // Si hay nueva imagen, subir y eliminar la anterior
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Subir nueva imagen
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Generar el slug automáticamente desde el nombre
        $validated['slug'] = Str::slug($validated['name']);

        // Actualizar el producto
        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina el producto de la base de datos
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Eliminar la imagen del storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Eliminar el producto
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
