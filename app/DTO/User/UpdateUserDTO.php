<?php

namespace App\DTO\User;

use Illuminate\Http\Request;

class UpdateUserDTO 
{    
    public function __construct(public string $id, public string $name, public string $email){}

    public static function makeFromRequest(Request $request, int $id = null) {
        return new self(
            $id ?? $request->id,
            $request->name,
            $request->email,
        );
    }
}