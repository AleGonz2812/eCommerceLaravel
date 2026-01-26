<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Mostrar el carrito de compras
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();
        
        // Calcular total
        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Añadir un producto al carrito
     *
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Verificar si hay stock disponible
        if ($product->stock <= 0) {
            return redirect()->back()
                ->with('error', 'Lo sentimos, este producto no tiene stock disponible.');
        }

        $user = Auth::user();

        // Verificar si el producto ya está en el carrito
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Si ya existe, incrementar la cantidad
            $newQuantity = $cartItem->quantity + 1;
            
            // Verificar que no exceda el stock
            if ($newQuantity > $product->stock) {
                return redirect()->back()
                    ->with('warning', 'No puedes agregar más unidades. Stock máximo: ' . $product->stock);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();

            return redirect()->back()
                ->with('success', 'Cantidad actualizada en el carrito.');
        } else {
            // Si no existe, crear nuevo item
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->price,
            ]);

            return redirect()->back()
                ->with('success', '¡Producto agregado al carrito!');
        }
    }

    /**
     * Actualizar la cantidad de un producto en el carrito
     *
     * @param \Illuminate\Http\Request $request
     * @param int $cartItemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuantity(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = $cartItem->product;

        // Verificar que no exceda el stock
        if ($request->quantity > $product->stock) {
            return redirect()->back()
                ->with('error', 'La cantidad solicitada excede el stock disponible (' . $product->stock . ' unidades).');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', 'Cantidad actualizada correctamente.');
    }

    /**
     * Eliminar un producto del carrito
     *
     * @param int $cartItemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($cartItemId)
    {
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $productName = $cartItem->product->name;
        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', $productName . ' eliminado del carrito.');
    }

    /**
     * Vaciar completamente el carrito
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Carrito vaciado correctamente.');
    }

    /**
     * Obtener el número de items en el carrito (para el contador en navbar)
     *
     * @return int
     */
    public static function getCartCount()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->sum('quantity');
        }
        return 0;
    }
}
