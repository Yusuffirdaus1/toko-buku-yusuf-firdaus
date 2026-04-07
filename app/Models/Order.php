<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total', 'status', 'address', 'phone',
        'payment_method', 'shipping_courier', 'tracking_number',
        'shipped_at', 'completed_at'
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentProof()
    {
        return $this->hasOne(PaymentProof::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'   => '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>',
            'confirmed' => '<span class="badge bg-info">Dikonfirmasi</span>',
            'shipped'   => '<span class="badge bg-primary">Dikirim</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
            default     => '<span class="badge bg-secondary">' . $this->status . '</span>',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
