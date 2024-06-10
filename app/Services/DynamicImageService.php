<?php

namespace App\Services;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
 * Class DynamicImageService
 * @package App\Services
 */
class DynamicImageService
{
    public function uploadImage($image, $path)
    {
        try {
            if ($image && $path) {
                $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->storeAs('public/' . $path, $imageName);
                $path =  $path . '/' . $imageName;
                return $path;
            } else {
                return null;
            }
        } catch (\Throwable $e) {
            echo 'Image Helper saveImage ' . $e->getMessage();
        }
    }

    public function upload(String $name, Request $request, String $module, String $alternate)
    {
        try {
            $image = $request->file($name);
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path =  $name . '/' . $module . '/' . $imageName;
            $image->storeAs($name . '/' . $module . '/', $imageName, ['disk' => 'public']);
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            return [
                'status' => 'success',
                'path' => $path,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function update(String $name, Request $request, String $module, String $alternate, $pathbefore){
        try {
            Storage::disk('public')->delete($pathbefore);
            $image = $request->file($name);
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path =  $name . '/' . $module . '/' . $imageName;
            $image->storeAs($name . '/' . $module . '/', $imageName, ['disk' => 'public']);
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();

            // dd($image);
            return [
                'status' => 'success',
                'path' => $path,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'message' => $e
            ];
        }
    }

    public function delete($pathbefore)
    {
        try {
            $exists = Storage::disk('public')->exists($pathbefore);
            if($exists){
                Storage::disk('public')->delete($pathbefore);
            }
            return true;
        } catch (QueryException $e) {
            return $e;
        }
    }

    public function showImage($filename)
    {
        $filename = trim($filename);
        $exists = Storage::disk('public')->exists($filename);
        $response = url('uploads/default/noimage.png');
        if($exists) {
            $response = asset($filename);
            return $response;
        } else {
        //    return $response;
        return null;
        }
    }
}
