<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

abstract class AbstractCLIDriver extends AbstractDriver
{
    protected $executablePath;

    public function __construct(string $executablePath = null)
    {
        if (!function_exists('exec')) {
            throw new \Exception("CLI drivers can't be used with the current configuration because exec is disabled");
        }
        $this->executablePath = $executablePath;
    }

    public function executablePath()
    {
        return $this->executablePath ?? static::DEFAULT_EXECUTABLE;
    }
}
