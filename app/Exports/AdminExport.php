<?php

namespace App\Exports;

use App\Models\Admin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection()
    {
        return Admin::with('user.roles')
            ->get()
            ->map(function ($item) {
                return [
                  'nama_lengkap' => $item->nama,
                  'no_hp' => $item->no_hp,
                  'email' => $item->user->email,
                  'role' => $item->user->roles->first()->name,
                  'alamat_lengkap' => $item->alamat,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Lengkap', 'No Hp', 'Email', 'Role', 'Alamat Lengkap'];
    }
}
