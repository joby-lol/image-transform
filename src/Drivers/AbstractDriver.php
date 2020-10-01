<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\DriverInterface;

abstract class AbstractDriver implements DriverInterface
{
    protected $source;

    public function source(string $source)
    {
        // set source
        $this->source = $source;
        // validate file
        if (!is_file($this->source)) {
            throw new \Exception("Image file doesn't exist: " . htmlentities($this->source));
        }
        if (!exif_imagetype($this->source)) {
            throw new \Exception("Invalid image file: " . htmlentities($this->source));
        }
        // get height/width
        list($this->originalWidth, $this->originalHeight) = getimagesize($this->source);
    }
}
