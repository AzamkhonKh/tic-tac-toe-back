<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
        return [
            'creator_id' => ['required', 'exists:users,id'],
            'opponent_id' => ['required', 'exists:users,id'],
            'grid' => ['required', 'integer'],
            'game_finished' => ['boolean'],
            'creator_win' => ['boolean'],
            'schedulet_at' => ['required', 'date:Y-m-d'],
            'state' => ['nullable'],
        ];
    }
}
