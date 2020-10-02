<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\DriverInterface;
use ByJoby\ImageTransform\Image;
use ByJoby\ImageTransform\Sizers\AbstractSizer;

abstract class AbstractDriver implements DriverInterface
{
    protected $tempDir = null;
    protected $chmod = 0775;

    abstract protected function doSave(Image $image, string $filename);

    public function __clone()
    {
        $this->tempDir = null;
    }

    public function image(string $src, AbstractSizer $sizer): Image
    {
        return new Image($src, $this, $sizer);
    }

    public function tempDir(): string
    {
        if (!$this->tempDir) {
            $this->setTempDir(sys_get_temp_dir() . '/byjoby_image-transform/' . uniqid("", true));
        }
        return $this->tempDir;
    }

    protected function setTempDir(string $dir)
    {
        if (!$this->mkdir($dir)) {
            throw new \Exception("Temp directory " . htmlentities($dir) . " doesn't exist or isn't writeable, and couldn't be created.");
        }
        $this->tempDir = $dir;
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

    public function save(Image $image, ?string $filename = null): ?string
    {
        if ($filename) {
            if (is_file($filename)) {
                if (!is_writeable($filename)) {
                    throw new \Exception("Can't save image because file already exists and is not writeable: " . htmlentities($filename));
                }
            } else {
                if (!$this->mkdir(dirname($filename))) {
                    throw new \Exception("Can't save image because parent directory isn't writeable or couldn't be created: " . htmlentities($filename));
                }
                touch($filename);
            }
            $this->doSave($image, realpath($filename));
            return null;
        } else {
            $filename = $this->tempDir() . '/save.jpg';
            $this->doSave($image, $filename);
            return file_get_contents($filename);
        }
    }
}
