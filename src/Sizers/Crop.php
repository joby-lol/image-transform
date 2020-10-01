<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Sizers;

class Crop extends AbstractSizer
{
    protected $width, $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function width(): int
    {
        return $this->width;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function resizeToHeight(): ?int
    {
        return null;
    }

    public function resizeToWidth(): ?int
    {
        return null;
    }

    public function cropToWidth(): ?int
    {
        return $this->width;
    }

    public function cropToHeight(): ?int
    {
        return $this->height;
    }
}
