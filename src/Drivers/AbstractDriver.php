<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\DriverInterface;
use ByJoby\ImageTransform\Image;
use ByJoby\ImageTransform\Sizers\AbstractSizer;

abstract class AbstractDriver implements DriverInterface
{
    protected $tmpDir = null;
    protected $chmod = 0775;

    public function __construct()
    {
        $this->__clone();
    }

    public function __clone()
    {
        $this->setTempDir(sys_get_temp_dir() . '/byjoby_image-transform/' . uniqid("",true));
    }

    public function image(string $src, AbstractSizer $sizer): Image
    {
        return new Image($src, $this, $sizer);
    }

    public function setTempDir(string $dir)
    {
        if (!$this->mkdir($dir)) {
            throw new \Exception("Temp directory " . htmlentities($dir) . " doesn't exist or isn't writeable, and couldn't be created.");
        }
        $this->tmpDir = $dir;
    }

    protected function mkdir(string $dir)
    {
        // return true if dir exists and is writeable
        if (is_dir($dir) && is_writeable($dir)) {
            return true;
        }
        // recursively ensure parent directory exists
        $parent = dirname($dir);
        $this->mkdir($parent);
        // try to create this directory if it doesn't exist
        if (is_dir($parent)) {
            // check parent permissions
            if (!is_writeable($parent)) {
                chmod($parent, $this->chmod);
            }
            if (!is_writeable($parent)) {
                return false;
            }
            // create this directory
            if (!mkdir($dir)) {
                return false;
            }
            chmod($dir, $this->chmod);
            return is_writeable($dir);
        } else {
            // parent doesn't exist, so recursive call failed
            return false;
        }
    }
}
