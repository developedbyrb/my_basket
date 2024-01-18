<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUpload
{
    /**
     * @return $this|false|string
     */
    public function upload(Request $request, $data, $fieldname = 'image', $directory = 'images')
    {
        if ($request->hasFile($fieldname)) {
            $title = str_replace(['\'', '"', ',', ';', '<', '>'], ' ', $request->name);
            $name = preg_replace('/\s+/', '', $title).'_'.time();
            $folder = '/'.$directory.'/'.$data->id;

            return $request->file($fieldname)
                ->storeAs($folder, $name.'.'.$request->file($fieldname)->clientExtension(), 'public');
        }

        return null;
    }
}
