<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

use ByJoby\ImageTransform\Sizers\AbstractSizer;
use ByJoby\ImageTransform\Sizers\Original;

class Image
{
    protected $source;
    protected $driver;
    protected $originalWidth;
    protected $originalHeight;
    protected $rotation = 0;
    protected $flipH = false;
    protected $flipV = false;
    protected $sizer = null;

    public function __construct(string $source, AbstractSizer|null $sizer = null)
    {
        $this->setSource($source);
        $this->setSizer($sizer ?? new Original());
    }

    public function source(): string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        // set source
        $this->source = realpath($source);
        if (!$this->source) {
            throw new \Exception("Source image not found: " . htmlentities($source));
        }
        // validate file
        if (!is_file($this->source)) {
            throw new \Exception("Image file doesn't exist: " . htmlentities($this->source));
        }
        if (!exif_imagetype($this->source)) {
            throw new \Exception("Invalid image file: " . htmlentities($this->source));
        }
        // get height/width
        list($this->originalWidth, $this->originalHeight) = getimagesize($this->source);
        // return self
        return $this;
    }

    public function sizer(): AbstractSizer
    {
        return $this->sizer;
    }

    public function setSizer(AbstractSizer $sizer): static
    {
        $this->sizer = clone $sizer;
        $this->sizer->image($this);
        return $this;
    }

    public function rotate(int $steps = 1): static
    {
        $this->rotation = ($this->rotation + $steps) % 4;
        return $this;
    }

    public function rotation(): int
    {
        return $this->rotation;
    }

    public function flipH(): static
    {
        $this->flipH = !$this->flipH;
        return $this;
    }

    public function flipV(): static
    {
        $this->flipV = !$this->flipV;
        return $this;
    }

    public function getFlipH(): bool
    {
        return $this->flipH;
    }

    public function getFlipV(): bool
    {
        return $this->flipV;
    }

    public function width(): int
    {
        return $this->sizer->width();
    }

    public function height(): int
    {
        return $this->sizer->height();
    }

    public function ratio(): float
    {
        return $this->width() / $this->height();
    }

    public function originalRatio(): float
    {
        return $this->originalWidth() / $this->originalHeight();
    }

    public function originalWidth(): int
    {
        return $this->originalWidth;
    }

    public function originalHeight(): int
    {
        return $this->originalHeight;
    }

    public function driver(): DriverInterface
    {
        return $this->driver ?? DefaultDriver::get();
    }

    public function save(string $file): static
    {
        $this->driver()->save($this, $file);
        return $this;
    }
}