<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Drivers;

use ByJoby\ImageTransform\DriverInterface;
use ByJoby\ImageTransform\Image;
use ByJoby\ImageTransform\Sizers\AbstractSizer;
use Exception;

abstract class AbstractDriver implements DriverInterface
{
    /** @var string|null */
    protected $tempDir = null;
    /** @var int */
    protected $chmod_dir = 0775;
    /** @var int */
    protected $chmod_file = 0665;

    abstract protected function doSave(Image $image, string $filename): void;

    public function tempDir(): string
    {
        if (!$this->tempDir) {
            $this->setTempDir(sys_get_temp_dir() . '/byjoby_image-transform/' . uniqid("", true));
        }
        // @phpstan-ignore-next-line this is actually checked
        return $this->tempDir;
    }

    public function setTempDir(string $dir): static
    {
        if (!$this->mkdir($dir)) {
            throw new \Exception("Temp directory " . htmlentities($dir) . " doesn't exist or isn't writeable, and couldn't be created.");
        }
        $this->tempDir = $dir;
        return $this;
    }

    protected function mkdir(string $dir): bool
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
                chmod($parent, $this->chmod_dir);
            }
            if (!is_writeable($parent)) {
                return false;
            }
            // create this directory
            if (!mkdir($dir)) {
                return false;
            }
            chmod($dir, $this->chmod_dir);
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
            $filename = realpath($filename);
            if (!$filename) throw new Exception("Invalid filename or path");
            $this->doSave($image, $filename);
            chmod($filename, $this->chmod_file);
            return null;
        } else {
            $filename = $this->tempDir() . '/' . uniqid() . '.jpg';
            $this->doSave($image, $filename);
            /** @var string we can count on this being a string because we just wrote it */
            $output = file_get_contents($filename);
            unlink($filename);
            return $output;
        }
    }
}