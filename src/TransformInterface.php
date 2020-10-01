<?php
/* image-transform | https://github.com/jobyone/image-transform | MIT License */
namespace ByJoby\ImageTransform;

interface TransformInterface
{
    /**
     * Whether this transformer changes the contents of the image. Used when
     * optimizing transformation order.
     */
    const CHANGES_CONTENT = false;

    /**
     * Whether this transformer changes the size of the image. Used when
     * optimizing transformation order.
     */
    const CHANGES_SIZE = false;

    /**
     * Whether this transformer changes the colors of the image. Used when
     * optimizing transformation order.
     */
    const CHANGES_COLOR = false;

    /**
     * Whether or not applying this transform multiple times will always
     * produce the same result. Used with optimizing transformation order.
     */
    const TRANSFORM_STABLE = true;

    /**
     * Optionally return an array of other transforms that perform the
     * operations necessary to perform this single transform.
     * 
     * If this method returns anything, the Image object will add the
     * Transformers returned here, and this object will be discarded.
     * 
     * This allows new Transformers to be constructed by composing
     * existing ones.
     *
     * @return array
     */
    public function chain(): array;

    /**
     * Return whether or not this transformation will impact the given
     * Image. Should return true if it's possible, as it will be
     * skipped if it returns false.
     *  @return bool
     */
    public function willTransform(Image $image): bool;
}
