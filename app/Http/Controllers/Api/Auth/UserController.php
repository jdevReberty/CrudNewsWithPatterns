<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTO\User\{CreateUserDTO, UpdateUserDTO};
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Services\UserServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(
        protected UserServices $service
    ){}
    
    public function create() {
        return response()->json([
            "status" => 200,
            "message" => "Cadastrar Usuário"
        ]);
    }

    public function store(UserCreateRequest $request) {
        try {
            $user = $this->service->create(
                CreateUserDTO::makeFromRequest($request)
            );

            $token = $user->createToken($request->device_name ?? "default")->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'User created with success',
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

    public function update(UserCreateRequest $request) {
        try {
            if(!Hash::check($request->password, auth()->user()->password)) {
                throw ValidationException::withMessages(['A senha informada está incorreta']);
            }
            $this->service->update(
                UpdateUserDTO::makeFromRequest($request)
            );
            $user = User::find($request->id);
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

    public function delete(User $user) {
        try {
            if($user->id == auth()->user()->id) throw new Exception("The user cannot delete their own account");
            $dontHasNews = $user->news()->get()->isEmpty();
            
            if($dontHasNews) {
                DB::table('user_roles')->where('id_user', $user->id)->delete();
                $user->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "User deleted with success"
                ]);
            } 
            throw new Exception("Fail! This user has news created");
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
}
