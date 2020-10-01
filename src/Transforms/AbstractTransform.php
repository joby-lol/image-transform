<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;
use ByJoby\ImageTransform\TransformInterface;

abstract class AbstractTransform implements TransformInterface
{
    public function chain(): array
    {
        return [];
    }

    public function willTransform(Image $image): bool
    {
        return true;
    }
}
