<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Exception;

class RegisterController extends Controller
{
    public function register(UserRequest $request)
    {
        $phone = $request->phone;

        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $phone,
                'birthday' => $request->birthday,
                'city_id' => $request->city_id,
            ]);

            DB::commit();

            return response()->json(new UserResource($user), 201);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Register Failed'], 500);
        }
    }
}
