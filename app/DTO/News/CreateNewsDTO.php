<?php

namespace App\DTO\News;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateNewsDTO 
{
    // public string $status;
    
    public function __construct(public string $title, public string $content, public int $id_user)
    {
        
    }

    public static function makeFromRequest(Request $request) {
        return new self(
            $request->title,
            $request->content,
            $request->id_user ?? Auth::user()->id 
        );
        // $request->status,
    }
}