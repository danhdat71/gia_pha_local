<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;

trait FileTrait
{
    public function storePublicImage($image, $path = 'img/family_member')
    {
        if(!File::isDirectory(public_path($path)) ) {
            File::makeDirectory($path, 493, true);
        }
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $path . "/" . $filename;
        $storagePath = public_path($path);
        Image::make($image)->fit(500, 500)->save($storagePath);

        return $path;
    }

    public function storeCCCD($imageFile)
    {
        $fileName = Str::random(10) . time(). ".jpg";
        $image = Image::make($imageFile)->encode('jpg', 90);
        Storage::disk('private')->put("cccd/".$fileName, $image->encode());

        return $fileName;
    }

    public function storeAvatar($imageFile)
    {
        $fileName = Str::random(10) . time() . ".jpg";
        $image = Image::make($imageFile)->fit(600, 600)->encode('jpg', 90);
        Storage::disk('private')->put("avatar/".$fileName, $image->encode());

        return $fileName;
    }

    public function storeProof($imageFile)
    {
        $fileName = Str::random(10) . time() . ".jpg";
        $image = Image::make($imageFile)->encode('jpg', 90);
        Storage::disk('private')->put("proof/".$fileName, $image->encode());

        return $fileName;
    }

    public function storeBlogAvatar($imageFile)
    {
        $fileName = Str::random(10) . time() . ".jpg";
        $image = Image::make($imageFile)->encode('jpg', 90);
        Storage::disk('private')->put("blogs_avatar/".$fileName, $image->encode());

        return $fileName;
    }

    public function storeRestImage($imageFile)
    {
        $fileName = Str::random(10) . time() . ".jpg";
        $image = Image::make($imageFile)->encode('jpg', 90);
        Storage::disk('private')->put("rest_images/".$fileName, $image->encode());

        return $fileName;
    }

    public function storeCertImage($imageFile)
    {
        $fileName = Str::random(10) . time() . ".jpg";
        $image = Image::make($imageFile)->encode('jpg', 90);
        Storage::disk('private')->put("cert_images/".$fileName, $image->encode());

        return $fileName;
    }

    public function getCCCD($imageName)
    {
        $imageFullPath = storage_path('app/private/cccd/' . $imageName);
        return Image::make($imageFullPath)->response();
    }

    public function getAvatar($imageName)
    {
        $imageFullPath = storage_path('app/private/avatar/' . $imageName);
        return Image::make($imageFullPath)->response();
    }

    public function getProof($imageName)
    {
        $imageFullPath = storage_path('app/private/proof/' . $imageName);
        return Image::make($imageFullPath)->response();
    }

    public function get360VideoReview($videoName)
    {
        $video = Storage::disk('private')->get("video/$videoName");
        $response = Response::make($video, 200);
        return $response->header('Content-Type', 'video/mp4');
    }

    public function getVr3DReview($fileName)
    {
        $file = Storage::disk('private')->get("vr_3d/$fileName");
        $response = Response::make($file, 200);
        return $response->header('Content-Type', 'video/mp4');
    }

    public function getBlogAvatar($imageName)
    {
        $imageFullPath = storage_path('app/private/blogs_avatar/' . $imageName);
        return Image::make($imageFullPath)->response();
    }

    public function getRestImg($imageName)
    {
        $imageFullPath = storage_path('app/private/rest_images/' . $imageName);
        return Image::make($imageFullPath)->response();
    }

    public function getCertImg($imageName)
    {
        $imageFullPath = storage_path('app/private/cert_images/' . $imageName);
        return Image::make($imageFullPath)->response();
    }

    public function storeRestVideo360($videoFile)
    {
        $fileName = Str::random(10) . time() . ".mp4";
        Storage::disk('private')->putFileAs("video", $videoFile, $fileName);
        return $fileName;
    }

    public function storeVr3DFile($file)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = Str::random(10) . time() . "." . $fileExtension;
        Storage::disk('private')->putFileAs("vr_3d", $file, $fileName);
        return $fileName;
    }

    public function removeImage($imageFullPath)
    {
        Storage::delete($imageFullPath);
    }
}