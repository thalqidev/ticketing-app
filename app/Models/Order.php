<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'order_date',
        'total_harga',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tikets(): BelongsToMany
    {
        return $this->belongsToMany(Tiket::class, 'detail_orders')
            ->withPivot('jumlah', 'subtotal_harga');
    }

    public function events(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class);
    }
}