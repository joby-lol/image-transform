<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;
use Gmagick;
use GmagickPixel;
use Imagick;
use ImagickPixel;

/**
 * This driver uses either ImageMagick or Gmagick, depending on its constructor
 * argument.
 */
class MagickDriver extends AbstractExtensionDriver
{
    /**
     * By default this driver will use Imagick, but if you pass a true value it
     * will instead use Gmagick.
     *
     * @param boolean $use_gmagick
     */
    public function __construct(protected bool $use_gmagick = false)
    {
    }

    protected function getImageObject(Image $image): Gmagick|Imagick
    {
        if ($this->use_gmagick) return new Gmagick($image->source());
        else return new Imagick($image->source());
    }

    /**
     * @param Gmagick|Imagick $object
     * @param Image $image
     * @return Gmagick|Imagick
     */
    protected function doResize($object, Image $image): Gmagick|Imagick
    {
        $sizer = $image->sizer();
        if ($sizer->resizeToHeight() && $sizer->resizeToWidth()) {
            if ($object instanceof Gmagick) {
                $object->resizeimage(
                    $sizer->resizeToWidth(),
                    $sizer->resizeToHeight(),
                    Gmagick::FILTER_LANCZOS,
                    0
                );
            } else {
                $object->resizeImage(
                    $sizer->resizeToWidth(),
                    $sizer->resizeToHeight(),
                    Imagick::FILTER_LANCZOS,
                    0
                );
            }
        }
        return $object;
    }

    /**
     * @param Gmagick|Imagick $object
     * @param Image $image
     * @return Gmagick|Imagick
     */
    protected function doCrop($object, Image $image): Gmagick|Imagick
    {
        $sizer = $image->sizer();
        $height = $sizer->cropToHeight();
        $width = $sizer->cropToWidth();
        if ($height && $width) {
            $x = intval(($sizer->resizetoWidth() - $width) / 2);
            $y = intval(($sizer->resizetoHeight() - $height) / 2);
            if ($object instanceof Gmagick) {
                $object->cropimage(
                    $width,
                    $height,
                    $x,
                    $y
                );
            } else {
                $object->cropImage(
                    $width,
                    $height,
                    $x,
                    $y
                );
            }
        }
        return $object;
    }

    /**
     * @param Gmagick|Imagick $object
     * @param Image $image
     * @return Gmagick|Imagick
     */
    protected function doFlip($object, Image $image): Gmagick|Imagick
    {
        if ($image->getFlipH()) {
            if ($object instanceof Gmagick) $object->flipimage();
            else $object->flipImage();
        }
        if ($image->getFlipV()) {
            if ($object instanceof Gmagick) $object->flopimage();
            else $object->flopImage();
        }
        return $object;
    }

    /**
     * @param Gmagick|Imagick $object
     * @param Image $image
     * @return Gmagick|Imagick
     */
    protected function doRotation($object, Image $image): Gmagick|Imagick
    {
        if ($image->rotation()) {
            if ($object instanceof Gmagick) $object->rotateimage(new GmagickPixel("#000"), $image->rotation() * 90);
            else $object->rotateImage(new ImagickPixel("#000"), $image->rotation() * 90);
        }
        return $object;
    }

    /**
     * @param Gmagick|Imagick $object
     * @param string $filename
     * @return void
     */
    protected function saveImageObject($object, string $filename): void
    {
        /** @var string */
        $format = preg_replace('/^.+\./', '', $filename);
        $format = strtoupper($format);
        if ($format == 'JPG') $format = 'JPEG';
        if ($object instanceof Gmagick) {
            $object->setimageformat($format);
            $object->writeimage($filename, true);
        } else {
            $object->setImageFormat($format);
            $object->writeImage($filename);
        }
    }
}