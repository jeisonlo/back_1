<?php

namespace App\Policies;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlaylistPolicy
{
    public function view(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }

    public function update(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }

    public function delete(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }
}
