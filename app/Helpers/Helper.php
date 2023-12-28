<?php

namespace App\Helpers;

class Helper
{
    public static function hasPermissionToView($permissionName, $isAccessByAdmin = true): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // If user has admin role, they have permission
        if ($isAccessByAdmin && $user->hasRole('admin')) {
            return true;
        }

        // If user has a specific role with the given permission, they have permission
        if ($user->role && $user->role->hasPermission($permissionName)) {
            return true;
        }

        return false;
    }
}
