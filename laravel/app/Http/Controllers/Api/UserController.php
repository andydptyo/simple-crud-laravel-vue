<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search') ?? '';
        $query = User::where('first_name', 'like', '%'.$search.'%')
        ->orWhere('last_name', 'like', '%'.$search.'%');

        if ($filter = request('filter')) {
            $query = User::whereHas('city', function ($city) use ($filter) {
                return $city->where('id', $filter);
            });
        }

        $users = new UserCollection($query->get());

        return response()->json($users, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = new UserResource(User::find($id));

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attr = $request->all();
        $user = User::where('id', $id)->first();

        if (! $user) {
            return response()->json([
                'message' => 'Not Found.'
            ], 404);
        }

        $attr['city_id'] = $request->city;
        $user->update($attr);

        if ($request->is_admin) {
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
        }

        return response()->json([
            'message' => 'success',
            'user' => new UserResource($user),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if (! $user) {
            return response()->json([
                'message' => 'Not Found.'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
