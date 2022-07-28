<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse(new UserCollection($users), __('user.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // this route exluded, maybe in future we would need this!
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        return $this->sendResponse(UserResource::make($user), __('user.data', ['name' => $user->name]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $user = User::find($id);
        if(request('new_password')){
            // we should, update user password and his token !
            $validated['password'] = bcrypt(request('new_password'));
        }
        
        if($user->update($validated)){
            if(isset($validated['password'])){
                // he updated password, so we should recreate token
                // think about recreating token by response 
                // (better to do on client side after changing password do login)
                $user->tokens()->delete();
            }
        }
        return $this->sendResponse(UserResource::make($user->refresh()), __('user.updated', ['name' => $user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->delete()){
            return $this->sendResponse([], __('user.deleted'));
        }else{
            return $this->sendError(__('error.delete',['model' => $user->name]));
        }
    }
}
