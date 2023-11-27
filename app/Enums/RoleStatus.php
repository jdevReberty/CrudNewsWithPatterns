<?php

namespace App\Enums;

enum RoleStatus: string {

    case commum = "Commum";
    case admin = "Admin";
    case blocked = "Blocked";

    public static function fromValue(string $value) : string {
        foreach(self::cases() as $case) {
            if($case->name == $value) return $case->value;
        } 
        throw new \ValueError("Status is not valid");
    }
}
