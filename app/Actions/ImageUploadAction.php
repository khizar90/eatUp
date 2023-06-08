<?php

namespace App\Actions;

class ImageUploadAction{

    public function handle($path,$image)
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/' .$path, $filename);
        return $filename;
    }

}