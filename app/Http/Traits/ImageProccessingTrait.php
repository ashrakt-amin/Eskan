<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait ImageProccessingTrait
{
    private $path = 'images';

    /**
     * img extenstions
     */
    public function getMime($mime)
    {
        if ($mime == 'image/jpg')
            $extension = '.jpg';
        elseif ($mime == 'image/jpeg')
            $extension = '.jpeg';
        elseif ($mime == 'image/png')
            $extension = '.png';
        elseif ($mime == 'image/gif')
            $extension = '.gif';
        elseif ($mime  == 'image/svg+xml')
            $extension = '.svg';
        elseif ($mime == 'image/tiff')
            $extension = '.tiff';
        elseif ($mime == 'image/webp')
            $extension = '.webp';

        return $extension;
    }

    /**
     * Set Image
     */
    public function imageName($image)
    {
        $img = Image::make($image);
        $extension = $this->getMime($img->mime());

        $strRandom = Str::random(8);
        $imgPath   = $strRandom . time() . $extension;

        return $imgPath;
    }

   
    
    public function setImage($image, $path)
    {
        Image::make($image);
       $data = $image->store($this->path . '/' . $path, 'public');
        return   $data;
    }

    /**
     * Set array of Images
     */
    // public function setImages($images, $path, $column, $width = null, $height = null)
    // {
    //     $imagesName = [];
    //     foreach ($images as $image) {
    //         array_push($imagesName, [$column => $this->setImage($image, $path, $width, $height)]);
    //     }
    //     return $imagesName;
    // }

    public function aspectForResizeImages($images , $path , $column ,  $width = null, $height = null)
    {
             $width;
             $height;
        $imagesName = [];
        foreach ($images as $image) {
            array_push($imagesName, [$column => $this->aspectForResize($image, $path, $width, $height)]);
                }
                return $imagesName;

    }

    public function setImages($images, $path, $column, $width, $height)
    {
        $imagesName = [];
        foreach($images as $image){
            array_push($imagesName, [ $column => $this->aspectForResize($image, $path, $width, $height)]);
        }
        return $imagesName;
    }
    /**
     * update image width and height
     */
    public function aspectForResize($image, $path,$width, $height)
    {
        $img = Image::make($image);
        $name = $image->getClientOriginalName();
        $extension = $this->getMime($img->mime());
        $strRandom = Str::random(8);
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imgPath = $strRandom . $name;
        $thepath = storage_path('app/public/images/'.$path);
        if (!File::exists($thepath)) {
            File::makeDirectory($thepath, 0755, true, true);
        }
        $img->save($thepath . '/' . $imgPath);
        return $imgPath ;
    }

    public function setImageWithoutsize($image, $path)
    {
        $img = Image::make($image);
        $name = $image->getClientOriginalName();
        $strRandom = Str::random(8);
        $imgPath = $strRandom . $name;
        $thepath = storage_path('app/public/images/'.$path);
        if (!File::exists($thepath)) {
            File::makeDirectory($thepath, 0755, true, true);
        }
        $img->save($thepath . '/' . $imgPath);
        return $imgPath ;
    }


    /**
     * crop image width and height
     */
    public function aspectForCrop($image, $ownerId, $width, $height, $path)
    {
        $img = Image::make($image);

        $name = $image->getClientOriginalName();

        $extension = $this->getMime($img->mime());
        $strRandom = Str::random(8);
        $img->crop($width, $height, 0, 0);
        $imgPath = $ownerId . $name;
        $img->save(public_path('../assets/images/uploads/' . $path) . '/' . $imgPath);

        return $imgPath;
    }

    /**
     * Thumbnail image width and height
     */
    public function ImageThumbnail($image, $ownerId, $path, $thumb = false)
    {
        $dataArray = array();
        $img = Image::make($image);

        $name            = $image->getClientOriginalName();
        $imgPath   = $ownerId . $name;
        $dataArray['image'] = $imgPath;
        if ($thumb) {
            // sm image
            $dataArray['thumbnailSm'] = $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(storage_path('app/assets/images/uploads/' . $path . '/sm') . '/' . $imgPath);
            // md image
            $dataArray['thumbnailSm'] = $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(storage_path('app/assets/images/uploads/' . $path . '/md') . '/' . $imgPath);
            // lg image
            $dataArray['thumbnailSm'] = $img->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(storage_path('app/assets/images/uploads/' . $path . '/lg') . '/' . $imgPath);
        }
        return $dataArray;
    }

    /**
     * Delete image
     */
    public function deleteImage($location, $filename)
    {
        // return Storage::delete('images/'.$location.'/'.$filename);
        return Storage::disk('public')->delete($this->path . '/' . $location . '/' . $filename);

    }

    /**
     * Delete images
     */
    public function deleteImages($images, $location)
    {
        foreach ($images as $image) {
            $this->deleteImage($location, $image);
        }
    }
}
