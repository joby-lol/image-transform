<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;

/**
 * This driver uses PHP's built-in GD libary. This is by far the slowest driver,
 * and its memory use is absolutely atrocious for large images, but support is
 * basically universal.
 */
class GDDriver extends AbstractExtensionDriver
{
    public function __construct()
    {
        if (!extension_loaded('gd')) {
            throw new \Exception("GD driver can't be used because the extension is not loaded");
        }
    }

    protected function getImageObject(Image $image)
    {
        $source = $image->source();
        $extension = strtolower(preg_replace('/^.+\./', '', $source));
        switch ($extension) {
            case 'bmp':
                return imagecreatefrombmp($source);
            case 'gif':
                return imagecreatefromgif($source);
            case 'jpg':
                return imagecreatefromjpeg($source);
            case 'jpeg':
                return imagecreatefromjpeg($source);
            case 'png':
                return imagecreatefrompng($source);
            case 'wbmp':
                return imagecreatefromwbmp($source);
            case 'webp':
                return imagecreatefromwebp($source);
            case 'xbm':
                return imagecreatefromxbm($source);
            default:
                throw new \Exception("Unsupported input type: " . htmlentities($source));
        }
    }

    protected function doResize($object, Image $image)
    {
        $sizer = $image->sizer();
        if ($sizer->resizeToHeight() && $sizer->resizeToWidth()) {
            // sizer is calling for a resize
            $new = imagecreatetruecolor($sizer->resizeToWidth(), $sizer->resizeToHeight());
            imagecopyresampled(
                $new, $object,
                0, 0,//dst x/y
                0, 0,
                $sizer->resizeToWidth(), $sizer->resizeToHeight(),
                $sizer->originalWidth(), $sizer->originalHeight()
            );
            return $new;
        } else {
            // sizer isn't calling for a resize, return object unchanged
            return $object;
        }
    }

    protected function doCrop($object, Image $image)
    {
        $sizer = $image->sizer();
        if ($sizer->cropToHeight() && $sizer->cropToWidth()) {
            // sizer is calling for a crop
            $new = imagecreatetruecolor($sizer->cropToWidth(), $sizer->cropToHeight());
            imagecopyresampled(
                $new, $object,
                ($sizer->cropToWidth()-$sizer->resizeToWidth())/2,($sizer->cropToHeight()-$sizer->resizeToHeight())/2,
                0,0,
                $sizer->resizetoWidth(),$sizer->resizeToHeight(),$sizer->resizeToWidth(),$sizer->resizeToHeight()
            );
            return $new;
        } else {
            // sizer isn't calling for a resize, return object unchanged
            return $object;
        }
    }

    protected function doFlip($object, Image $image)
    {
        if ($image->getFlipH()) {
            imageflip($object,IMG_FLIP_HORIZONTAL);
        }
        if ($image->getFlipV()) {
            imageflip($object,IMG_FLIP_VERTICAL);
        }
        return $object;
    }

    protected function doRotation($object, Image $image)
    {
        if ($rotationAmount = 360 - $image->rotation() * 90) {
            return imagerotate($object, $rotationAmount, 0);
        }
        return $object;
    }

    protected function saveImageObject($object, string $filename)
    {
        $extension = strtolower(preg_replace('/^.+\./', '', $filename));
        switch ($extension) {
            case 'bmp':
                return imagebmp($object, $filename);
            case 'gif':
                return imagegif($object, $filename);
            case 'jpg':
                return imagejpeg($object, $filename);
            case 'jpeg':
                return imagejpeg($object, $filename);
            case 'png':
                return imagepng($object, $filename);
            case 'wbmp':
                return imagewbmp($object, $filename);
            case 'webp':
                return imagewebp($object, $filename);
            case 'xbm':
                return imagexbm($object, $filename);
            default:
                throw new \Exception("Unsupported output type: " . htmlentities($filename));
        }
    }
}
