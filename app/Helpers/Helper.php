<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Helper
{
    public static function hasPermissionToView($permissionName, $isAccessByAdmin = true): bool
    {
        $user = auth()->user();

        if (! $user) {
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
        $name = ! is_null($filename) ? $filename : Str::random(25);

        return $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->clientExtension(), $disk);
    }

    public static function secret($string, $action = 'e')
    {
        $secret_key = 'YourSecretKey';
        $secret_iv = 'YourSecretIv';
        $output = false;
        $encrypt_method = 'AES-256-CBC';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        }
        if ($action == 'd') {
            $output = openssl_decrypt($string, $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}
