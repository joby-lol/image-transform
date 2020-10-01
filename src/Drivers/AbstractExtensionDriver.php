<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;

abstract class AbstractExtensionDriver extends AbstractDriver
{
    abstract protected function getImageObject(Image $image);
    abstract protected function doResize($object, Image $image);
    abstract protected function doCrop($object, Image $image);
    abstract protected function doFlip($object, Image $image);
    abstract protected function doRotation($object, Image $image);
    abstract protected function saveImageObject($object, string $filename);

    public function doSave(Image $image, string $filename)
    {
        $object = $this->getImageObject($image);
        $object = $this->doRotation($object, $image);
        $object = $this->doResize($object, $image);
        $object = $this->doCrop($object, $image);
        $object = $this->doFlip($object, $image);
        $this->saveImageObject($object, $filename);
    }
}
