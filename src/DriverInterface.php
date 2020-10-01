<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

interface DriverInterface
{
    public function source(string $source);
    public function originalWidth(): int;
    public function originalHeight(): int;
}
