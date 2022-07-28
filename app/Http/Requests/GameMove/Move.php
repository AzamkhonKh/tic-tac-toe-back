<?php

namespace App\Http\Requests\GameMove;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\GameMove;
use TheSeer\Tokenizer\Exception;
use App\Models\Game;

class Move extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // check last move
        $is_it_by_himself = Game::where('id', $this->game_id)
            ->whereRaw('creator_id != opponent_id')
            ->count();
        if ($is_it_by_himself && GameMove::where('game_id', $this->game_id)->last()->user_id == $this->user_id){
            throw new Exception("You can not play from two side ))");
        }
        $this->user_id = auth()->id();
        return [
            'game_id' => ['required', 'exists:games,id'],
            'user_id' => ['required'],
            'height_number' => ['required', 'integer'],
            'row_number' => ['required', 'integer']
        ];
    }
}
