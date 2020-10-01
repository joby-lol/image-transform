<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

class Image
{
    protected $src, $driver;
    protected $transforms = [];

    public function __construct(string $src, DriverInterface $driver)
    {
        $this->src = $src;
        $this->driver = clone $driver;
        $this->driver->source($src);
    }

    public function transform(TransformInterface $transform)
    {
        $this->transforms[] = $transform;
    }

    public function originalWidth(): int
    {
        return $this->driver->originalWidth();
    }

    public function originalHeight(): int
    {
        return $this->driver->originalHeight();
    }
}
