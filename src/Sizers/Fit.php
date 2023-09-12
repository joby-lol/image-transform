<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Sizers;

class Fit extends AbstractSizer
{
    /** @var int */
    protected $width, $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function cropToWidth(): ?int
    {
        return null;
    }

    public function cropToHeight(): ?int
    {
        return null;
    }

    protected function targetRatio(): float
    {
        return $this->width / $this->height;
    }

    /**
     * @return array{height:int,width:int}
     */
    protected function calculateSize(): array
    {
        if ($this->targetRatio() > $this->originalRatio()) {
            $height = $this->height;
            $width = intval(round($height * $this->originalRatio()));
        } else {
            $width = $this->width;
            $height = intval(round($width / $this->originalRatio()));
        }
        return [
            'height' => $height,
            'width' => $width,
        ];
    }

    public function width(): int
    {
        return $this->calculateSize()['width'];
    }

    public function height(): int
    {
        return $this->calculateSize()['height'];
    }
}
