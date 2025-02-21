<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Announcement $announcement)
    {
        return $user->id === $announcement->user_id;
    }

    public function delete(User $user, Announcement $announcement)
    {
        return $user->id === $announcement->user_id;
    }
}
