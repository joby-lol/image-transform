<?php

use ByJoby\ImageTransform\Drivers\GDDriver;
use ByJoby\ImageTransform\Sizers\Cover;

include __DIR__ . '/../vendor/autoload.php';

// first step is instantiate a Driver, in this case GD
$driver = new GDDriver();

// instantiate an Image object using a source file and Sizer
// in this example we're covering a 200x500 box
$image = $driver->image(
    'example-portrait.jpg',
    new Cover(200, 500)
);

// currently the only operation supported are 90 degree rotation and flipping
$image->rotate(); //rotates by 90 degrees
$image->flipH(); //flips horizontally, use flipV to flip vertically

// use save() to build the image and save it to a file
$image->save('out/example-1.jpg');

// display the generated file in the browser
echo '<img src="out/example-1.jpg">';

// output peak memory usage
var_dump(memory_get_peak_usage());
