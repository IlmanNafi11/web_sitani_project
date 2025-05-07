<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKondisi extends Model
{
    protected $fillable = [
        'kelompok_tani_id',
        'komoditas_id',
        'status',
        'penyuluh_id',
    ];

    /**
     * Relasi one to one dengan model laporan kondisi detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<LaporanKondisiDetail, LaporanKondisi>
     */
    public function laporanKondisiDetail()
    {
        return $this->hasOne(LaporanKondisiDetail::class);
    }

    /**
     * Relasi one to many dengan model kelompok tani
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<KelompokTani, LaporanKondisi>
     */
    public function kelompokTani()
    {
        return $this->belongsTo(KelompokTani::class);
    }

    /**
     * Relasi one to many dengan model komoditas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Komoditas, LaporanKondisi>
     */
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class);
    }

    /**
     * relasi one to many dengan model penyuluh
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Penyuluh, LaporanKondisi>
     */
    public function penyuluh()
    {
        return $this->belongsTo(Penyuluh::class);
    }
}
