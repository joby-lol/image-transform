<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\tests\units\Sizers;

use atoum;
use ByJoby\ImageTransform\Sizers\Cover as SizerUnderTest;
use ByJoby\ImageTransform\tests\units\mock\MockDriver;

class Cover extends atoum
{
    public function testPortraitWhenImageIsTaller()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',100,150))
            ->integer($image->width())->isEqualTo(100)
            ->integer($image->height())->isEqualTo(150)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(100)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(200)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(100)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(150)
            ->given($image->rotate())
                ->integer($image->width())->isEqualTo(100)
                ->integer($image->height())->isEqualTo(150)
                ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
                ->variable($image->sizer()->resizeToHeight())->isEqualTo(150)
                ->variable($image->sizer()->cropToWidth())->isEqualTo(100)
                ->variable($image->sizer()->cropToHeight())->isEqualTo(150)
        ;
    }

    public function testPortraitWhenImageIsShorter()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',50,300))
            ->integer($image->width())->isEqualTo(50)
            ->integer($image->height())->isEqualTo(300)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(150)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(50)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(300)
            ->given($image->rotate())
                ->integer($image->width())->isEqualTo(50)
                ->integer($image->height())->isEqualTo(300)
                ->variable($image->sizer()->resizeToWidth())->isEqualTo(600)
                ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
                ->variable($image->sizer()->cropToWidth())->isEqualTo(50)
                ->variable($image->sizer()->cropToHeight())->isEqualTo(300)
        ;
    }

    public function testPortraitWithSquareImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x200.jpg',75,300))
            ->integer($image->width())->isEqualTo(75)
            ->integer($image->height())->isEqualTo(300)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(75)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(300)
        ;
    }

    public function testPortraitWithLandscapeImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',100,200))
            ->integer($image->width())->isEqualTo(100)
            ->integer($image->height())->isEqualTo(200)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(400)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(200)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(100)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(200)
        ;
    }

    public function testLandscapeWhenImageIsTaller()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',150,100))
            ->integer($image->width())->isEqualTo(150)
            ->integer($image->height())->isEqualTo(100)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(200)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(100)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(150)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(100)
        ;
    }

    public function testLandscapeWhenImageIsShorter()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',300,75))
            ->integer($image->width())->isEqualTo(300)
            ->integer($image->height())->isEqualTo(75)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(150)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(300)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(75)
        ;
    }

    public function testLandscapeWithSquareImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x200.jpg',300,75))
            ->integer($image->width())->isEqualTo(300)
            ->integer($image->height())->isEqualTo(75)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(300)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(75)
        ;
    }

    public function testLandscapeWithPortraitImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',200,100))
            ->integer($image->width())->isEqualTo(200)
            ->integer($image->height())->isEqualTo(100)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(200)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(400)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(200)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(100)
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
            ->variable($image->sizer()->cropToWidth())->isEqualTo(300)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(300)
        ;
    }

    public function testWithSmallLandscapeImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../200x100.jpg',300,300))
            ->integer($image->width())->isEqualTo(300)
            ->integer($image->height())->isEqualTo(300)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(600)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(300)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(300)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(300)
        ;
    }

    public function testWithSmallPortraitImage()
    {
        $this
            ->given($image = $this->image(__DIR__.'/../100x200.jpg',300,300))
            ->integer($image->width())->isEqualTo(300)
            ->integer($image->height())->isEqualTo(300)
            ->variable($image->sizer()->resizeToWidth())->isEqualTo(300)
            ->variable($image->sizer()->resizeToHeight())->isEqualTo(600)
            ->variable($image->sizer()->cropToWidth())->isEqualTo(300)
            ->variable($image->sizer()->cropToHeight())->isEqualTo(300)
        ;
    }

    protected function image(string $path, int $width, int $height)
    {
        $driver = new MockDriver();
        return $driver->image($path, new SizerUnderTest($width, $height));
    }
}
