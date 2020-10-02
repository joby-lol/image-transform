<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

abstract class AbstractCLIDriver extends AbstractDriver
{
    public function __construct()
    {
        if (!function_exists('exec')) {
            throw new \Exception("CLI drivers can't be used with the current configuration because exec is disabled");
        }
    }
}
