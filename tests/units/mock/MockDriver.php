<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\tests\units\mock;

use ByJoby\ImageTransform\Drivers\AbstractDriver;
use ByJoby\ImageTransform\Image;

class MockDriver extends AbstractDriver
{
    protected function doSave(Image $image, string $filename)
    {
        //does nothing
    }
}
