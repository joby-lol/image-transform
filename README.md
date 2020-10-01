# image-transform

A tightly-focused library for performing a very limited set of simple image transformations. This library's purpose is to eschew the standard kitchen sink approach to PHP image libraries in favor of high performance, wide driver support, and a dead simple API.

## Roadmap

This library is under active development, and until a 1.0 release is made you should expect it to potentially be broken, and unexpectedly and dramatically change its API and functionality. That said, I *do* have use of this thing for work, so I'm probably going to be working pretty dang hard on it, and hope to have a stable release by about November of 2020.

### Drivers

A 1.0 release will not be made until the following drivers are available and solidly tested:

* GD
* Imagick
* Gmagick
* GmagickCLI

### Transforms

A 1.0 release will be made available once the following transforms are available and solidly tested across all drivers. These are basically what I see as the bare minimum for such a library to be useful.

* orientation
  * rotate (in 90 degree increments)
  * mirror-h
  * mirror-v
* size
  * fit (basically an alias for max-width and max-height)
  * cover (scale to cover a box, then crop excess)
  * crop (crop toward the center to a given size)
  * cover-crop (convenience transform, combining cover and crop, useful for thumbnails)

More complex, and also lesser used effects/stages that may or may not make it into 1.0

* color effects
  * grayscale
  * colorize
* content effects
  * overlay
  * blur
  * hue
  * saturation
  * brightness

#### Order of operations

In the name of simplicity and ease of use, the effective order of operations will always be as reflected above:

1. Orientation
2. Resizing and cropping
3. Color effects
4. Content-changing effects

This is only the effective order of operations, because to improve performance the *actual* order of operations, if applicable, will be:

1. Resizing and cropping
2. Orientation
3. Color effects
4. Content-changing effects
