<?php

use ByJoby\ImageTransform\Drivers\ImagickCLIDriver;
use ByJoby\ImageTransform\Sizers\Cover;
use ByJoby\ImageTransform\Sizers\Crop;
use ByJoby\ImageTransform\Sizers\Fit;
use ByJoby\ImageTransform\Sizers\Original;

include __DIR__ . '/../vendor/autoload.php';

$driver = new ImagickCLIDriver();
// $sizer = new Fit(1000, 500);
// $sizer = new Original();
$sizer = new Crop(500,400);

$image = $driver->image(
    'example-portrait.jpg',
    $sizer
);
// $image->rotate();

var_dump(
    'crop: width: '.$image->sizer()->cropToWidth(),
    'crop: height: '.$image->sizer()->cropToHeight(),
    'resize: width: '.$image->sizer()->resizeToWidth(),
    'resize: height: '.$image->sizer()->resizeToHeight(),
    'final: width: '.$image->width(),
    'final: height: '.$image->height(),
    $image
);
