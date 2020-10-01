<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

/**
 * This driver is designed to use exec() and your OS's binary Imagick
 * installation to do all of its image transforms. This will likely be
 * the highest-performance driver of all in most situations, but does
 * require that you have CLI Imagick installed, and that your server allows
 * PHP's exec() function to use it.
 */
class ImagickCLIDriver extends AbstractDriver
{}
