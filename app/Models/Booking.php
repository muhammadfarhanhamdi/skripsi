<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
        'created_by',
        'booking_date',
        'booking_time',
        'customer_name',
        'customer_phone',
        'source',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public static function statusLabels(): array
    {
        return [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'arrived' => 'Datang',
            'completed' => 'Selesai',
            'canceled' => 'Batal',
        ];
    }

    public static function statusClasses(): array
    {
        return [
            'pending' => 'bg-slate-100 text-slate-700 ring-slate-200',
            'confirmed' => 'bg-sky-100 text-sky-700 ring-sky-200',
            'arrived' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'completed' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'canceled' => 'bg-rose-100 text-rose-700 ring-rose-200',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return static::statusLabels()[$this->status] ?? 'Tidak diketahui';
    }

    public function getStatusClassAttribute(): string
    {
        return static::statusClasses()[$this->status] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
