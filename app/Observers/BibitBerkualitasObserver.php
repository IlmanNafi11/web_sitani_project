<?php

namespace App\Observers;

use App\Events\NotifGenerated;
use App\Models\BibitBerkualitas;
use App\Models\User;

class BibitBerkualitasObserver
{
    /**
     * Handle the BibitBerkualitas "created" event.
     */
    public function created(BibitBerkualitas $bibitBerkualitas): void
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'penyuluh')
                ->where('guard_name', 'api');
        })->get();

        foreach ($users as $user) {
            event(new NotifGenerated(
                $user,
                'Bibit Baru Tersedia',
                'Admin menambahkan bibit baru: ' . ($bibitBerkualitas->nama ?? 'bibit'),
                'bibit_baru'
            ));
        }
    }

    /**
     * Handle the BibitBerkualitas "updated" event.
     */
    public function updated(BibitBerkualitas $bibitBerkualitas): void
    {
        //
    }

    /**
     * Handle the BibitBerkualitas "deleted" event.
     */
    public function deleted(BibitBerkualitas $bibitBerkualitas): void
    {
        //
    }

    /**
     * Handle the BibitBerkualitas "restored" event.
     */
    public function restored(BibitBerkualitas $bibitBerkualitas): void
    {
        //
    }

    /**
     * Handle the BibitBerkualitas "force deleted" event.
     */
    public function forceDeleted(BibitBerkualitas $bibitBerkualitas): void
    {
        //
    }
}
