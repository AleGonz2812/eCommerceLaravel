<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * Generar número de orden único
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Relación con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con OrderItems
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Obtener el total de items
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }
}
