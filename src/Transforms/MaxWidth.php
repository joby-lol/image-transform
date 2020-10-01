<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;

class MaxWidth extends AbstractTransform
{
    const CHANGES_SIZE = true;

    protected $size;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function willTransform(Image $image): bool
    {
        if ($image->originalWidth() <= $this->size) {
            return false;
        } else {
            return true;
        }
    }
}
