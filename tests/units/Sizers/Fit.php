<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\tests\units\Sizers;

use atoum;
use ByJoby\ImageTransform\Sizers\Fit as SizerUnderTest;
use ByJoby\ImageTransform\tests\units\mock\MockDriver;

class Fit extends atoum
{
    public function testPortraitWhenImageIsTaller()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',100,150))
            ->integer($image->width())->isEqualTo(75)
            ->integer($image->height())->isEqualTo(150)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(75)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(150)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
            ->given($image->rotate())
                ->integer($image->width())->isEqualTo(100)
                ->integer($image->height())->isEqualTo(50)
                ->variable($image->sizer()->resizeToWidth())->isEqualTo(100)
                ->variable($image->sizer()->resizeToHeight())->isEqualTo(50)
                ->variable($image->sizer()->cropToWidth())->isNull()
                ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testPortraitWhenImageIsShorter()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',50,300))
            ->integer($image->width())->isEqualTo(50)
            ->integer($image->height())->isEqualTo(100)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(50)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(100)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
            ->given($image->rotate())
                ->integer($image->width())->isEqualTo(50)
                ->integer($image->height())->isEqualTo(25)
                ->variable($image->sizer()->resizeToWidth())->isEqualTo(50)
                ->variable($image->sizer()->resizeToHeight())->isEqualTo(25)
                ->variable($image->sizer()->cropToWidth())->isNull()
                ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testPortraitWithSquareImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x200.jpg',75,300))
            ->integer($image->width())->isEqualTo(75)
            ->integer($image->height())->isEqualTo(75)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(75)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(75)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testPortraitWithLandscapeImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',100,200))
            ->integer($image->width())->isEqualTo(100)
            ->integer($image->height())->isEqualTo(50)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(100)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(50)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testLandscapeWhenImageIsTaller()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',150,100))
            ->integer($image->width())->isEqualTo(150)
            ->integer($image->height())->isEqualTo(75)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(150)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(75)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testLandscapeWhenImageIsShorter()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',300,75))
            ->integer($image->width())->isEqualTo(150)
            ->integer($image->height())->isEqualTo(75)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(150)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(75)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testLandscapeWithSquareImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x200.jpg',300,75))
            ->integer($image->width())->isEqualTo(75)
            ->integer($image->height())->isEqualTo(75)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(75)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(75)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testLandscapeWithPortraitImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',200,100))
            ->integer($image->width())->isEqualTo(50)
            ->integer($image->height())->isEqualTo(100)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(50)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(100)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testWithSmallSquareImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x200.jpg',300,300))
            ->integer($image->width())->isEqualTo(300)
            ->integer($image->height())->isEqualTo(300)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testWithSmallLandscapeImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',300,300))
            ->integer($image->width())->isEqualTo(300)
            ->integer($image->height())->isEqualTo(150)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(150)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    public function testWithSmallPortraitImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',300,300))
            ->integer($image->width())->isEqualTo(150)
            ->integer($image->height())->isEqualTo(300)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(150)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
            ->variable($image->sizer()->cropToWidth())->isNull()
            ->variable($image->sizer()->cropToHeight())->isNull()
        ;
    }

    protected function image(string $path, int $width, int $height)
    {
        $driver = new MockDriver();
        return $driver->image($path, new SizerUnderTest($width, $height));
    }
}
