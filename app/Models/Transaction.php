<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
        'booking_id',
        'kasir_id',
        'promotion_id',
        'queue_status',
        'price',
        'discount_percent',
        'payment_method',
        'paid_amount',
        'change_amount',
        'total',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'total' => 'decimal:2',
        'price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
    }
}
