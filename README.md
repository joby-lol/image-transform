# image-transform

A tightly-focused library for performing a very limited set of simple image transformations. This library's purpose is to eschew the standard kitchen sink approach to PHP image libraries in favor of high performance, wide driver support, and a dead simple API.

## Roadmap

This library is under active development, and until a 1.0 release is made you should expect it to potentially change its API and functionality. Possibly **drastically**. That said, I *do* have use of this thing for work, so I'm probably going to be working pretty dang hard on it, and hope to have a stable release by about November of 2020.

### Drivers

A 1.0 release will not be made until the following drivers are available and solidly tested:

* GD
* Imagick
* Gmagick
* GmagickCLI

### Transforms

A 1.0 release will be made available once the following transforms are available and solidly tested across all drivers:

* rotate (in 90 degree increments)
* mirror-h
* mirror-v
* max-width
* max-height
* fit (basically an alias for max-width and max-height)
* cover
* crop
* cover-crop (convenience transform, combining cover and crop, useful for thumbnails)

The following transforms are also on my mind as possibilities, but may or may not make it into 1.0:

* grayscale
* colorize (needs to function consistently though)
* overlay (i.e. for watermarking)
