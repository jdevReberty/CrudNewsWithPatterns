<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(AuthRequest $request) {
        try {
            $user = User::where('email', $request->email)->first();
            if($user == null) throw ValidationException::withMessages(['O e-mail informado está incorreto']);
            $checkPassword = Hash::check($request->password, $user->password);
            if ($checkPassword == false) throw ValidationException::withMessages(['A senha informada está incorreta']);

            //caso queira login único
            $user->tokens()->delete();

            $token = $user->createToken($request->device_name ?? "default")->plainTextToken;

            return response()->json([
                'token' => $token,

            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => 403,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function getAuthUser() {
        return response()->json([
            'user' => auth()->user()
        ]);
    }
}
