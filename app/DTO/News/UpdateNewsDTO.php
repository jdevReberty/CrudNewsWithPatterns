<?php

namespace App\DTO\News;

use Illuminate\Http\Request;

class UpdateNewsDTO 
{

    // public string $status;
    
    public function __construct(public string $id, public string $title, public string $content){}

    public static function makeFromRequest(Request $request) {
        return new self(
            $request->id,
            $request->title,
            $request->content
        );
        // $request->status,
    }
}