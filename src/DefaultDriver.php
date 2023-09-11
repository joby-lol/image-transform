<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

use ByJoby\ImageTransform\Drivers\GDDriver;

/**
 * Stores a default driver to be used when a driver is not set for an Image.
 * Defaults to a GD driver.
 */
class DefaultDriver
{
    protected $driver;

    public static function get(): DriverInterface
    {
        return static::$driver
            ?? static::$driver = new GDDriver();
    }

    public static function set(DriverInterface $driver): void
    {
        static::$driver = $driver;
    }
}