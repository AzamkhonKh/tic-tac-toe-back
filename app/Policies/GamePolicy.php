<?php

namespace App\Policies;
use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    public function delete(User $user, Game $game)
    {
        return $user->id === $game->creator_id;
    }
}