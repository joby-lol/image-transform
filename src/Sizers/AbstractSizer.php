<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Sizers;

use ByJoby\ImageTransform\Image;

abstract class AbstractSizer
{
    /** @var Image */
    protected $image;

    abstract public function width(): int;
    abstract public function height(): int;
    abstract public function cropToWidth(): ?int;
    abstract public function cropToHeight(): ?int;

    public function resizeToWidth(): ?int
    {
        return $this->width();
    }

    public function resizeToHeight(): ?int
    {
        return $this->height();
    }

    public function originalWidth(): int
    {
        if ($this->image->rotation() % 2) {
            return $this->image->originalHeight();
        }else {
            return $this->image->originalWidth();
        }
    }

    public function originalHeight(): int
    {
        if ($this->image->rotation() % 2) {
            return $this->image->originalWidth();
        }else {
            return $this->image->originalHeight();
        }
    }

    public function originalRatio(): float
    {
        return $this->originalWidth()/$this->originalHeight();
    }

    public function setImage(Image $image): static
    {
        $this->image = $image;
        return $this;
    }
}
