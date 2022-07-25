<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Http\Requests\Game\Store;
use App\Http\Requests\GameMove\Move;
use App\Models\GameMove;
use App\Repository\RedisRepo;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->id();
        $response = Game::where('creator_id', $id)
            ->orWhere('opponent_id', $id)
            ->get();
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $game = Game::create($request->validated());
        return $game;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);
        return $game;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, $id)
    {
        $game = Game::find($id)->update($request->validated());
        return $game;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        if(auth()->id() == $game->creator_id){
            $msg = 'can\'t delete game !';
            if($game->deleted()){
                $msg = 'deleted succesfully';
                $code = 201;
            }
            $code = 200;
        }else{
            $msg = 'you are not creator of this game';
            $code = 400;
        }

        return response()->json([
            'message' => $msg
        ], $code);
    }

    public function move(Move $req){
        $move = GameMove::create($req->validated());
        // #todo : this do not work on windows env
        // $redis = new RedisRepo();
        // $redis->setValue('game:'.request('game_id').':moves:'.$move->id);
        return $move;
    }
}
