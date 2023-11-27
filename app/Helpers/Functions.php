<?php 

namespace App\Helpers;

use App\Services\UserServices;
use App\Enums\RoleStatus;

if(!function_exists('isAdmin')) {
    function getIsAdmin() : string {
        return UserServices::isAdmin();
    }
}

// if(!function_exists('getNewsStatus')) {
//     function getNewsStatus(string $status) : string {
//         return NewsStatus::fromValue($status);
//     }
// }