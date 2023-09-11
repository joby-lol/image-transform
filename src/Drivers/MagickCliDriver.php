<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\Image;

/**
 * This driver uses exec() and command-line ImageMagick (or Gmagick) utilities
 * to transform images. It is likely approaching the limits of how fast this
 * library can possibly be. The downside is that it will only run if you have
 * exec() enabled, and your server allows it to execute the ImageMagick/Gmagick
 * binaries and use them to read and write image files.
 */
class MagickCliDriver extends AbstractCliDriver
{
    protected $mogrify_executable;

    public function __construct($mogrify_executable = 'magick mogrify')
    {
        parent::__construct();
        $this->mogrify_executable = $mogrify_executable;
    }

    protected function mogrifyExecutable(): string
    {
        return $this->mogrify_executable;
    }

    protected function doSave(Image $image, string $filename)
    {
        // basics of command
        $command = [
            $this->mogrifyExecutable(),
        ];
        // rotation
        if ($image->rotation()) {
            $command[] = '-rotate ' . ($image->rotation() * 90);
        }
        // flip/flop
        if ($image->getFlipH()) {
            $command[] = '-flop';
        }
        if ($image->getFlipV()) {
            $command[] = '-flip';
        }
        // resizing/cropping
        $sizer = $image->sizer();
        if ($sizer->resizeToWidth() || $sizer->cropToWidth()) {
            $command[] = '-resize ' . $sizer->resizeToWidth() . 'x' . $sizer->resizeToHeight();
        }
        if ($sizer->cropToWidth() && $sizer->cropToHeight()) {
            $command[] = '-gravity center';
            $command[] = '-extent ' . $sizer->cropToWidth() . 'x' . $sizer->cropToHeight();
        }
        // create temp file
        $tempFile = $this->tempDir() . '/' . uniqid() . '.' . basename($filename);
        copy($image->source(), $tempFile);
        // execute command and copy result
        $command[] = '"' . $tempFile . '"';
        exec(implode(' ', $command), $output, $return);
        if ($return) {
            throw new \Exception("Imagick CLI call failed, returned " . $return);
        }
        copy($tempFile, $filename);
    }
}
