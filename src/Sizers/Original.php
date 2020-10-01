<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Sizers;

class Original extends AbstractSizer
{
    public function resizeToWidth(): ?int
    {
        return null;
    }

    public function resizeToHeight(): ?int
    {
        return null;
    }

    public function cropToWidth(): ?int
    {
        return null;
    }

    public function cropToHeight(): ?int
    {
        return null;
    }

    public function width(): int
    {
        return $this->originalWidth();
    }

    public function height(): int
    {
        return $this->originalHeight();
    }
}
