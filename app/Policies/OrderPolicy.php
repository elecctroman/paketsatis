<?php

namespace App\Policies;

use Core\Rbac;
use Core\Auth;

class OrderPolicy
{
    public static function authorize(string $permission): bool
    {
        $user = Auth::user();
        return $user ? Rbac::can($user['role'], $permission) : false;
    }
}
