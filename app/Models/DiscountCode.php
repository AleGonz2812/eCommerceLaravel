<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'discount_percentage',
        'used',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Relación con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generar un código de descuento único
     */
    public static function generateCode()
    {
        do {
            $code = 'WELCOME' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Verificar si el código es válido
     */
    public function isValid()
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Marcar el código como usado
     */
    public function markAsUsed()
    {
        $this->update(['used' => true]);
    }
}
