<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

use ByJoby\ImageTransform\Sizers\AbstractSizer;

interface DriverInterface
{
    public function image(string $src, AbstractSizer $sizer): Image;
}
