<?php

namespace App\Helper;


use Illuminate\Support\Str;

class Helper
{
    // Upload Image
    public static function fileUpload($file, $folder, $name)
    {
        $imageName = Str::slug($name) . '.' . $file->extension();
        $file->move(public_path('uploads/' . $folder), $imageName);
        $path = 'uploads/' . $folder . '/' . $imageName;
        return $path;
    }

    //override or add env file or key
    public static function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env'); // get file ENV path
        if (file_exists($path)) {
            $val = '"' . trim($val) . '"';
            if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                file_put_contents($path, str_replace($type . '="' . env($type) . '"', $type . '=' . $val, file_get_contents($path)));
            } else {
                file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
            }
        }
    }
}
