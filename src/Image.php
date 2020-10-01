<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

use ByJoby\ImageTransform\Sizers\AbstractSizer;

class Image
{
    protected $source, $driver;
    protected $originalWidth, $originalHeight;
    protected $rotation = 0;
    protected $flipH = false;
    protected $flipV = false;
    protected $sizer = null;

    public function __construct(string $source, DriverInterface $driver, AbstractSizer $sizer)
    {
        $this->setSource($source);
        $this->setSizer($sizer);
        $this->driver = clone $driver;
    }

    public function source(): string
    {
        return $this->source;
    }

    public function setSource(string $source)
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
    }

    public function sizer(): AbstractSizer
    {
        return $this->sizer;
    }

    public function setSizer(AbstractSizer $sizer)
    {
        $this->sizer = clone $sizer;
        $this->sizer->image($this);
    }

    public function rotate(int $steps = 1)
    {
        $this->rotation = ($this->rotation + $steps) % 4;
    }

    public function rotation(): int
    {
        return $this->rotation;
    }

    public function flipH()
    {
        $this->flipH = !$this->flipH;
    }

    public function flipV()
    {
        $this->flipV = !$this->flipV;
    }

    public function getFlipH()
    {
        return $this->flipH;
    }

    public function getFlipV()
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

    public function save(string $file)
    {
        $this->driver->save($this, $file);
    }
}
