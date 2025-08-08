
<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

const STORAGE_PATH = "public"; // use public for local storage or s3 for aws

if (!function_exists('uploadFile')) {
    function uploadFile($file, $path, $returnWithPath = true)
    {
        // amazon url structure   bucket-name.s3.default-region.amazonaws.com/file_name

        // use public for local storage or s3 for aws
        $storage_type = env('STORAGE_TYPE') ?? 's3';

        // set the destination were you want to store
        $fileNameToStore = "";
        if ($storage_type == "public") {
            $fileNameToStore = $path;
        } else {
            $fileNameToStore = "storage/" . $path;
        }

        $uploadedPath = Storage::disk($storage_type)->put($fileNameToStore, $file);
        $uploadedPath = Storage::disk($storage_type)->url($uploadedPath);

        // relative file path
        if ($returnWithPath) {
            $fileNameToStore =  $path . '/' . basename($uploadedPath);
        } else {
            $fileNameToStore = basename($uploadedPath);
        }


        return $fileNameToStore;
    }
}
if (!function_exists('deleteFile')) {
    function deleteFile($file)
    {
        // use public for local storage or s3 for aws
        $storage_type = env('STORAGE_TYPE') ?? 's3';
        if ($storage_type == 'public') {
            if (File::exists($file)) {
                File::delete($file);
            }
        } else {
            if (Storage::disk($storage_type)->exists($file)) {
                Storage::disk($storage_type)->delete($file);
            }
        }
    }
}
if (!function_exists('FileExists')) {
    function FileExists($file)
    {
        // use public for local storage or s3 for aws
        $storage_type = env('STORAGE_TYPE') ?? 's3';
        if ($storage_type == 'public') {
            if (File::exists(public_path($file))) {
                return true;
            } else {
                return false;
            }
        } else {
            if (Storage::disk($storage_type)->exists($file)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
