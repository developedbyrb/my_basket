<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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

    public static function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        return $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->clientExtension(), $disk);
    }
}
