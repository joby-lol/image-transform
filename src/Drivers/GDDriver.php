<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;
use GdImage;

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

    protected function getImageObject(Image $image): GdImage
    {
        $source = $image->source();
        /** @var string */
        $extension = preg_replace('/^.+\./', '', $source);
        $extension = strtolower($extension);
        switch ($extension) {
            case 'bmp':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefrombmp($source);
            case 'gif':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefromgif($source);
            case 'jpg':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefromjpeg($source);
            case 'jpeg':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefromjpeg($source);
            case 'png':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefrompng($source);
            case 'wbmp':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefromwbmp($source);
            case 'webp':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefromwebp($source);
            case 'xbm':
                // @phpstan-ignore-next-line this will throw an exception, which is good
                return imagecreatefromxbm($source);
            default:
                throw new \Exception("Unsupported input type: " . htmlentities($source));
        }
    }

    /**
     * @param GdImage $object
     * @param Image $image
     * @return GdImage
     */
    protected function doResize($object, Image $image): GdImage
    {
        $sizer = $image->sizer();
        if ($sizer->resizeToHeight() && $sizer->resizeToWidth()) {
            // sizer is calling for a resize
            /** @var GdImage */
            $new = imagecreatetruecolor($sizer->resizeToWidth(), $sizer->resizeToHeight());
            imagecopyresampled(
                $new,
                $object,
                0,
                0,
                //dst x/y
                0,
                0,
                $sizer->resizeToWidth(), $sizer->resizeToHeight(),
                $sizer->originalWidth(), $sizer->originalHeight()
            );
            return $new;
        } else {
            // sizer isn't calling for a resize, return object unchanged
            return $object;
        }
    }

    /**
     * @param GdImage $object
     * @param Image $image
     * @return GdImage
     */
    protected function doCrop($object, Image $image): GdImage
    {
        $sizer = $image->sizer();
        if ($sizer->cropToHeight() && $sizer->cropToWidth()) {
            // sizer is calling for a crop
            /** @var GdImage */
            $new = imagecreatetruecolor($sizer->cropToWidth(), $sizer->cropToHeight());
            imagecopyresampled(
                $new,
                $object,
                ($sizer->cropToWidth() - $sizer->resizeToWidth()) / 2, ($sizer->cropToHeight() - $sizer->resizeToHeight()) / 2,
                0,
                0,
                // @phpstan-ignore-next-line these are definitely set
                $sizer->resizetoWidth(), $sizer->resizeToHeight(), $sizer->resizeToWidth(), $sizer->resizeToHeight()
            );
            return $new;
        } else {
            // sizer isn't calling for a resize, return object unchanged
            return $object;
        }
    }

    /**
     * @param GdImage $object
     * @param Image $image
     * @return GdImage
     */
    protected function doFlip($object, Image $image): GdImage
    {
        if ($image->getFlipH()) {
            imageflip($object, IMG_FLIP_HORIZONTAL);
        }
        if ($image->getFlipV()) {
            imageflip($object, IMG_FLIP_VERTICAL);
        }
        return $object;
    }

    /**
     * @param GdImage $object
     * @param Image $image
     * @return GdImage
     */
    protected function doRotation($object, Image $image): GdImage
    {
        if ($rotationAmount = 360 - $image->rotation() * 90) {
            // @phpstan-ignore-next-line
            return imagerotate($object, $rotationAmount, 0);
        }
        return $object;
    }

    /**
     * @param GdImage $object
     * @param string $filename
     * @return void
     */
    protected function saveImageObject($object, string $filename): void
    {
        /** @var string */
        $extension = preg_replace('/^.+\./', '', $filename);
        $extension = strtolower($extension);
        switch ($extension) {
            case 'bmp':
                imagebmp($object, $filename);
            case 'gif':
                imagegif($object, $filename);
            case 'jpg':
                imagejpeg($object, $filename);
            case 'jpeg':
                imagejpeg($object, $filename);
            case 'png':
                imagepng($object, $filename);
            case 'wbmp':
                imagewbmp($object, $filename);
            case 'webp':
                imagewebp($object, $filename);
            case 'xbm':
                imagexbm($object, $filename);
            default:
                throw new \Exception("Unsupported output type: " . htmlentities($filename));
        }
    }
}