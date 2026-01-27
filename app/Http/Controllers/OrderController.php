<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's order history
     * SCRUM-42: Mostrar productos comprados
     */
    public function index()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display specific order details
     * SCRUM-41: Vista de resumen de pedido
     * SCRUM-43: Mostrar total del pedido
     */
    public function show($id)
    {
        $order = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
