<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function create() {
        return response()->json([
            "status" => 200,
            "message" => "Cadastrar Usuário"
        ]);
    }

    public function store(UserCreateRequest $request) {
        try {
            $request->password = Hash::make($request->password);
            $newUser = User::create($request->toArray());

            $token = $newUser->createToken($request->device_name ?? "default")->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'User created with success',
                'user' => $newUser,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]); 
        }
    }

    public function update(UserCreateRequest $request) {
        try {
            if(!Hash::check($request->password, auth()->user()->password)) {
                throw ValidationException::withMessages(['A senha informada está incorreta']);
            }
            $user = User::find($request->id);
            $user->update($request->toArray());

            $token = $user->tokens();

            return response()->json([
                'status' => 200,
                'message' => 'User updated with success',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]); 
        }
    }
}
