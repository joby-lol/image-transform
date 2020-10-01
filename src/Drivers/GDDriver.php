<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

/**
 * This driver uses PHP's built-in GD libary. This is by far the slowest
 * driver, but support is basically universal.
 */
class GDDriver extends AbstractDriver
{}
