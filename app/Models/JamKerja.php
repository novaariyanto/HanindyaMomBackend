<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    //
       /**
     * Atribut yang dapat diisi (fillable).
     *
     * @var array
     */
       // Kolom yang dapat diisi secara massal
       protected $fillable = [
        'shift_id',       // Foreign key ke tabel shifts
        'senin_masuk',    // Jam masuk untuk Senin
        'senin_pulang',   // Jam pulang untuk Senin
        'selasa_masuk',   // Jam masuk untuk Selasa
        'selasa_pulang',  // Jam pulang untuk Selasa
        'rabu_masuk',     // Jam masuk untuk Rabu
        'rabu_pulang',    // Jam pulang untuk Rabu
        'kamis_masuk',    // Jam masuk untuk Kamis
        'kamis_pulang',   // Jam pulang untuk Kamis
        'jumat_masuk',    // Jam masuk untuk Jumat
        'jumat_pulang',   // Jam pulang untuk Jumat
        'sabtu_masuk',    // Jam masuk untuk Sabtu
        'sabtu_pulang',   // Jam pulang untuk Sabtu
        'minggu_masuk',   // Jam masuk untuk Minggu
        'minggu_pulang',  // Jam pulang untuk Minggu
    ];


    /**
     * Relasi dengan model Shift.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    
}
