<?php

namespace App\DTO\News;

use Illuminate\Http\Request;

class CreateNewsDTO 
{
    // public string $status;
    
    public function __construct(public string $title, public string $content)
    {
        
    }

    public static function makeFromRequest(Request $request) {
        return new self(
            $request->title,
            $request->content
        );
        // $request->status,
    }
}