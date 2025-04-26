<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelompokTaniResource extends JsonResource
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
            'nama' => $this->nama,
            'desa' => [
                'id' => $this->desa->id ?? null,
                'nama' => $this->desa->nama ?? null,
            ],
            'kecamatan' => [
                'id' => $this->kecamatan->id ?? null,
                'nama' => $this->kecamatan->nama ?? null,
            ],
            'penyuluhs' => $this->penyuluhTerdaftars->map(function ($penyuluh) {
                return [
                    'id' => $penyuluh->id,
                    'nama' => $penyuluh->nama,
                    'no_hp' => $penyuluh->no_hp,
                    'alamat' => $penyuluh->alamat,
                ];
            }),
        ];
    }
}
