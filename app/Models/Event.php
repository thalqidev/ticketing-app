<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'tanggal',
        'lokasi',
        'gambar',
        'tanggal_waktu',
        'durasi_jam',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    public function getStatusAttribute(): string
    {
        $waktuEvent = $this->tanggal_waktu;
        $sekarang = now();

        if ($waktuEvent->isFuture()) {
            return 'Upcoming';
        }

        $jamDurasi = $this->durasi_jam ?? 3;
        if ($waktuEvent->lte($sekarang) && $sekarang->lte($waktuEvent->copy()->addHours($jamDurasi))) {
            return 'Ongoing';
        }

        return 'Completed';
    }

    public function hasSales(): bool
    {
        return $this->orders()->exists();
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('tanggal_waktu', '>', now());
    }

    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('tanggal_waktu', '<=', now())
            ->whereRaw('DATE_ADD(tanggal_waktu, INTERVAL durasi_jam HOUR) >= ?', [now()]);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereRaw('DATE_ADD(tanggal_waktu, INTERVAL durasi_jam HOUR) < ?', [now()]);
    }

    public function getImageUrlAttribute(): string
    {
        $urlGambar = $this->gambar;

        if (filter_var($urlGambar, FILTER_VALIDATE_URL)) {
            return $urlGambar;
        }

        if ($urlGambar && Storage::disk('public')->exists($urlGambar)) {
            return Storage::disk('public')->url($urlGambar);
        }

        return asset('images/konser.jpg');
    }

    public function tikets(): HasMany
    {
        return $this->hasMany(Tiket::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}