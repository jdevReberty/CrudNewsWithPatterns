<?php

namespace App\DTO\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateUserDTO 
{
    // public string $status;
    
    public function __construct(
        public string $name, public string $email, public string $password
    ){}

    public static function makeFromRequest(Request $request) {
        return new self(
            $request->name,
            $request->email,
            Hash::make($request->password) 
        );
    }
}