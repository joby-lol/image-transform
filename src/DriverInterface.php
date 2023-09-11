<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

use ByJoby\ImageTransform\Sizers\AbstractSizer;

interface DriverInterface
{
    /**
     * Save an image with its current settings. If a filename is specified the
     * image will be saved to it and null returned, otherwise the image will be
     * returned as a string.
     *
     * @param Image $image
     * @param string|null $filename
     * @return string|null
     */
    public function save(Image $image, ?string $filename = null): ?string;

    /**
     * Set the temp directory in which files should be created if necessary for
     * processing images. A directory in the system temp folder will be used by
     * default.
     * 
     * @param string $dir
     * @return static
     */
    public function setTempDir(string $dir): static;
}