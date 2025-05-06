<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanKondisiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'kelompok_tani_id' => $this->kelompok_tani_id,
            'komoditas_id' => new KomoditasResource($this->whenLoaded('komoditas')),
            'created_at' => $this->created_at,
            'penyuluh' => new PenyuluhResource($this->whenLoaded('penyuluh')),
            'laporan_kondisi_detail' => new LaporanKondisiDetailResource($this->whenLoaded('laporanKondisiDetail')),
        ];
    }
}
