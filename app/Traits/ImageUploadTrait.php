<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait ImageUploadTrait
{
    protected $image_path  = "app/public/images/covers";
    protected $img_height = 600;
    protected $img_width = 600;

    public function uploadImage($img)
    {
        $img_name = $this->imageName($img);

        $manager = new ImageManager(new Driver());

        $image = $manager->read($img);

        $image->scale(
            width: $this->img_width,
            height: $this->img_height
        );

        $image->toJpeg()->save(
            storage_path($this->image_path . '/' . $img_name)
        );

        return "images/covers/" . $img_name;
    }

    public function imageName($image)
    {
        return time() . '-' . $image->getClientOriginalName();
    }
}