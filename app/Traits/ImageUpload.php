<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUpload
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function upload(Request $request, $fieldname = 'image', $directory = 'images', $data)
    {
        if ($request->hasFile($fieldname)) {
            $name = preg_replace('/\s+/', '', $request->name) . '_' . time();
            $folder = '/' . $directory . '/' . $data->id;
            return  $request->file($fieldname)->storeAs($folder, $name . '.' . $request->file($fieldname)->clientExtension(), 'public');
        }

        return null;
    }
}
