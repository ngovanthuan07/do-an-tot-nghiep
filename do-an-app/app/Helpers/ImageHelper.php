<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;


class ImageHelper
{
    public static function saveImage($directory, $file)
    {
        $path = public_path('media/' . $directory);

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $filename = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();

        while (File::exists($path . '/' . $filename)) {
            $filename = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        }

        $file->move($path, $filename);

        return $filename;
    }

    public static function deleteImage($directory, $filename)
    {
        $path = public_path('media/' . $directory . '/' . $filename);

        if (File::exists($path)) {
            File::delete($path);
            return true;
        } else {
            return false;
        }
    }
}
