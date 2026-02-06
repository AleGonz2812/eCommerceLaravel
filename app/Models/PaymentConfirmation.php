<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'code',
        'amount',
        'confirmed',
        'expires_at',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique token
     */
    public static function generateToken()
    {
        return Str::random(64);
    }

    /**
     * Generate a unique 6-digit code
     */
    public static function generateCode()
    {
        do {
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Check if token has expired
     */
    public function hasExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Mark as confirmed
     */
    public function markAsConfirmed()
    {
        $this->update(['confirmed' => true]);
    }
}
