<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;

abstract class AbstractExtensionDriver extends AbstractDriver
{
    // @phpstan-ignore-next-line we specify types in subclasses
    abstract protected function getImageObject(Image $image);
    // @phpstan-ignore-next-line we specify types in subclasses
    abstract protected function doResize($object, Image $image);
    // @phpstan-ignore-next-line we specify types in subclasses
    abstract protected function doCrop($object, Image $image);
    // @phpstan-ignore-next-line we specify types in subclasses
    abstract protected function doFlip($object, Image $image);
    // @phpstan-ignore-next-line we specify types in subclasses
    abstract protected function doRotation($object, Image $image);
    // @phpstan-ignore-next-line we specify types in subclasses
    abstract protected function saveImageObject($object, string $filename): void;

    public function doSave(Image $image, string $filename): void
    {
        $object = $this->getImageObject($image);
        $object = $this->doRotation($object, $image);
        $object = $this->doResize($object, $image);
        $object = $this->doCrop($object, $image);
        $object = $this->doFlip($object, $image);
        $this->saveImageObject($object, $filename);
    }
}
