<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'opponent_id' => $this->opponent_id,
            'grid' => $this->grid,
            'game_finished' => $this->game_finished,
            'creator_win' => $this->creator_win,
            'schedulet_at' => $this->schedulet_at
        ];
    }
}
