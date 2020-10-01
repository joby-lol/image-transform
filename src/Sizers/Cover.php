<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Sizers;

class Cover extends AbstractSizer
{
    protected $width, $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    protected function targetRatio(): float
    {
        return $this->width / $this->height;
    }

    protected function calculateSize(): array
    {
        if ($this->targetRatio() < $this->originalRatio()) {
            $height = $this->height;
            $width = round($height * $this->originalRatio());
        } else {
            $width = $this->width;
            $height = round($width / $this->originalRatio());
        }
        return [
            'height' => $height,
            'width' => $width,
        ];
    }

    public function height(): int
    {
        return $this->height;
    }

    public function width(): int
    {
        return $this->width;
    }

    public function resizeToWidth(): ?int
    {
        return $this->calculateSize()['width'];
    }

    public function resizeToHeight(): ?int
    {
        return $this->calculateSize()['height'];
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
