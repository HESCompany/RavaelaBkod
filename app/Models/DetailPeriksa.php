<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeriksa extends Model
{
    protected $fillable = [
        'id_periksa',
        'id_obat',
    ];

    /**
     * Validation rules
     */
    public static $rules = [
        'id_periksa' => 'required|exists:periksas,id',
        'id_obat' => 'required|exists:obats,id',
    ];

    /**
     * Relasi ke tabel Periksa
     */
    public function periksa(): BelongsTo
    {
        return $this->belongsTo(Periksa::class, 'id_periksa');
    }

    /**
     * Relasi ke tabel Obat
     */
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
