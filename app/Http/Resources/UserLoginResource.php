<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this;

        return [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'penyuluh' => new PenyuluhResource($this->whenLoaded('penyuluh')),
        ];
    }
}
