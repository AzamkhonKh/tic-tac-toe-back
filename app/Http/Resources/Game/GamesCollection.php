<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GamesCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Game\GameResource';
}
