<?php 

namespace App\Services;

use Illuminate\Http\Request;

class RequestCurrentUriServices {

    public function getRouteActionPrefix(Request $request) : string{
        return $request->route()->action['prefix'] ?? "";
    }

    public function isApiRequest(Request $request) : bool {
        if($this->getRouteActionPrefix($request) === "api") {
           return true;
        } 
        return false;
    }
}