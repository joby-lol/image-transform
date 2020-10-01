<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\tests\units\Sizers;

use atoum;
use ByJoby\ImageTransform\Sizers\Original as SizerUnderTest;
use ByJoby\ImageTransform\tests\units\mock\MockDriver;

class Original extends atoum
{
    public function testRotation()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg'))
            ->integer($image->width())->isEqualTo(100)
            ->integer($image->height())->isEqualTo(200)
            ->variable($image->sizer()->resizeToWidth())->isNull()
            ->variable($image->sizer()->resizeToHeight())->isNull()
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
            ->given($image->rotate())
                ->integer($image->width())->isEqualTo(200)
                ->integer($image->height())->isEqualTo(100)
                ->variable($image->sizer()->resizeToWidth())->isNull()
                ->variable($image->sizer()->resizeToHeight())->isNull()
                ->variable($image->sizer()->cropToWidth())->isNull()
                ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    protected function image(string $path)
    {
        $driver = new MockDriver();
        return $driver->image($path, new SizerUnderTest());
    }
}
