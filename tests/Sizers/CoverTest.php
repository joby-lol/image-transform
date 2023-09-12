<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform\Sizers;

use ByJoby\ImageTransform\Image;
use PHPUnit\Framework\TestCase;

class CoverTest extends TestCase
{
    public function testSquareImageSizedSquare(): void
    {
        // mock 200x200 image
        $image = $this->createMock(Image::class);
        $image->method("originalWidth")->willReturn(200);
        $image->method("originalHeight")->willReturn(200);
        // spin up a 50x50 sizer
        $sizer = new Cover(50, 50);
        $sizer->setImage($image);
        // resized to cover
        $this->assertEquals(50, $sizer->resizeToWidth());
        $this->assertEquals(50, $sizer->resizeToHeight());
        // cropped to size
        $this->assertEquals(50, $sizer->cropToWidth());
        $this->assertEquals(50, $sizer->cropToHeight());
    }

    public function testSquareImageSizedLandscape(): void
    {
        // mock 200x200 image
        $image = $this->createMock(Image::class);
        $image->method("originalWidth")->willReturn(200);
        $image->method("originalHeight")->willReturn(200);
        // spin up a 100x50 sizer
        $sizer = new Cover(100, 50);
        $sizer->setImage($image);
        // resized to cover
        $this->assertEquals(100, $sizer->resizeToWidth());
        $this->assertEquals(100, $sizer->resizeToHeight());
        // cropped to size
        $this->assertEquals(100, $sizer->cropToWidth());
        $this->assertEquals(50, $sizer->cropToHeight());
    }
    public function testSquareImageSizedPortrait(): void
    {
        // mock 200x200 image
        $image = $this->createMock(Image::class);
        $image->method("originalWidth")->willReturn(200);
        $image->method("originalHeight")->willReturn(200);
        // spin up a 50x100 sizer
        $sizer = new Cover(50, 100);
        $sizer->setImage($image);
        // resized to cover
        $this->assertEquals(100, $sizer->resizeToWidth());
        $this->assertEquals(100, $sizer->resizeToHeight());
        // cropped to size
        $this->assertEquals(50, $sizer->cropToWidth());
        $this->assertEquals(100, $sizer->cropToHeight());
    }

    public function testLandscapeImageSizedSquare(): void
    {
        // mock 200x100 image
        $image = $this->createMock(Image::class);
        $image->method("originalWidth")->willReturn(200);
        $image->method("originalHeight")->willReturn(100);
        // spin up a 50x50 sizer
        $sizer = new Cover(50, 50);
        $sizer->setImage($image);
        // resized to cover
        $this->assertEquals(100, $sizer->resizeToWidth());
        $this->assertEquals(50, $sizer->resizeToHeight());
        // cropped to size
        $this->assertEquals(50, $sizer->cropToWidth());
        $this->assertEquals(50, $sizer->cropToHeight());
    }

    public function testLandscapeImageSizedLandscape(): void
    {
        // mock 200x100 image
        $image = $this->createMock(Image::class);
        $image->method("originalWidth")->willReturn(200);
        $image->method("originalHeight")->willReturn(100);
        // spin up a 100x50 sizer
        $sizer = new Cover(100, 50);
        $sizer->setImage($image);
        // resized to cover
        $this->assertEquals(100, $sizer->resizeToWidth());
        $this->assertEquals(50, $sizer->resizeToHeight());
        // cropped to size
        $this->assertEquals(100, $sizer->cropToWidth());
        $this->assertEquals(50, $sizer->cropToHeight());
    }
    public function testLandscapeImageSizedPortrait(): void
    {
        // mock 200x100 image
        $image = $this->createMock(Image::class);
        $image->method("originalWidth")->willReturn(200);
        $image->method("originalHeight")->willReturn(100);
        // spin up a 50x100 sizer
        $sizer = new Cover(50, 100);
        $sizer->setImage($image);
        // resized to cover
        $this->assertEquals(200, $sizer->resizeToWidth());
        $this->assertEquals(100, $sizer->resizeToHeight());
        // cropped to size
        $this->assertEquals(50, $sizer->cropToWidth());
        $this->assertEquals(100, $sizer->cropToHeight());
    }
}