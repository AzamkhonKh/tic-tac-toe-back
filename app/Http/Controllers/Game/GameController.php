<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Requests\Game\Store;
use App\Http\Requests\GameMove\Move;
use App\Models\GameMove;
use App\Repository\RedisRepo;
use App\Http\Resources\Game\GamesCollection;
use App\Http\Resources\Game\GameResource;
use App\Http\Resources\Game\GameMoveResource;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $id = auth()->id();
        $games = Game::where('creator_id', $id)
            ->orWhere('opponent_id', $id)
            ->get();
        return $this->sendResponse(new GamesCollection($games), __('game.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Store $request)
    {
        $game = Game::create($request->validated());
        return $this->sendResponse(new GameResource($game), __('game.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $game = Game::find($id);
        return $this->sendResponse(new GameResource($game), __('game.show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Store  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Store $request, $id)
    {
        $game = Game::find($id)->update($request->validated());
        return $this->sendResponse(new GameResource($game), __('game.update'));
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
        if(auth()->user()->can('delete',$game) && $game->delete()){
            return $this->sendResponse([], __('game.deleted'));
        }else{
            return $this->sendError(__('error.delete',['model' => '']));
        }
    }

    public function move(Move $req){
        $move = GameMove::create($req->validated());
        // #todo : this do not work on windows env
        // $redis = new RedisRepo();
        // $redis->setValue('game:'.request('game_id').':moves:'.$move->id);
        return $this->sendResponse(new GameMoveResource($move), __('game.move.store'));
    }
}
