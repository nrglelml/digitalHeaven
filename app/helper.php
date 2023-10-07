<?php

use Intervention\Image\Facades\Image;

if (!function_exists('deleteFile')){
    function deleteFile($string){
        if (file_exists($string)){
            if (!empty($string)){
                unlink($string);
            }
        }
    }
}
if (!function_exists('openFile')) {
    function openFile($filepath, $permissions = 0777) {
        if (!file_exists($filepath)) {
            mkdir($filepath, $permissions, true);
        }
    }
}
if (!function_exists('addImage')) {
    function addImage($image,$name,$path) {
        $extension = $image->getClientOriginalExtension();
        $filename = time().'-'.Str::slug($name);
        if($extension == 'pdf' ||  $extension == 'svg' ||  $extension == 'webp' ||  $extension == 'jiff') {
            $image->move(public_path($path),$filename.'.'.$extension);
            $imageurl = $path.$filename.'.'.$extension;
        }else {
            $image = Image::make($image);
            $image->encode('webp', 75)->save($path.$filename.'.webp');
            $imageurl = $path.$filename.'.webp';
        }
        return  $imageurl;
    }
}

if (!function_exists('strLimit')) {
    function strLimit($text, $limit, $url = null) {
        if ($url == null) {
            $end = '...';
        } else {
            $end = '<a class="ml-2" href="' . $url . '">[...]</a>';
        }
        return Str::limit($text, $limit, $end);
    }
}
