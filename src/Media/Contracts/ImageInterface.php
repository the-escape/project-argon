<?php

namespace Escape\Argon\Media\Contracts;


interface ImageInterface
{
    /**
     * Get the url to the image.
     *
     * @return string
     */
    public function getUrl(array $args=[]);

    /**
     * Get the url to the unoptimized image and fallback to default.
     *
     * @return string
     */
    public function getUnoptimized();

    /**
     * Get the url to the thumbnail image and fallback to default.
     *
     * @return string
     */
    public function getThumb();

    /**
     * Get the url to the custom version of image and fallback to default.
     *
     * @return string
     */
    public function getCustomOption($option = '');

    /**
     * Get image width
     *
     * @return string
     */
    public function getWidth();

    /**
     * Get image height
     *
     * @return string
     */
    public function getHeight();
}
