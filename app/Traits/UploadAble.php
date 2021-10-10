<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadAble
{
    public function uploadfile(UploadedFile $file, $folder_name = null, $file_name = null, $disk = 'public')
    {
        if (!Storage::directories($disk . '/' . $folder_name)) {
            storage::makeDirectory($disk . '/' . $folder_name, 0777, true);
        }
        $fileNameWithExtension = $file->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtension, PATHINFO_EXTENSION);
        $extension = $file->getClientOriginalExtension();
        $fileNameStor = !is_null($file_name) ? $file_name . uniqid() . '.' . $extension : $fileName . uniqid() . '.' . $extension;
        $file->storeAs($folder_name, $fileNameStor, $disk);
        return $fileNameStor;
    }

    public function delete_file($file_name, $folder_name, $disk = 'public')
    {
        if (Storage::exists($disk .'/'. $folder_name . $file_name)) {
            storage::disk($disk)->delete($folder_name . $file_name);
            return true;
        }
        return false;
    }
}
