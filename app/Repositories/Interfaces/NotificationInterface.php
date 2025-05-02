<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface NotificationInterface
{
    /**
     * Mengambil data notifikasi pengguna
     *
     * @param User $user model user
     * @return Collection|array
     */
    public function getUserNotification(User $user): Collection|array;

    /**
     * Menandai notifikasi sudah dibaca
     *
     * @param User $user model user
     * @param string|int $id notification id
     * @return bool
     */
    public function markNotificationAsRead(User $user, string|int $id): bool;

    /**
     * Menghapus notifikasi pengguna
     *
     * @param User $user model user
     * @param string|int $id notification id
     * @return bool
     */
    public function deleteNotification(User $user, string|int $id): bool;

}
