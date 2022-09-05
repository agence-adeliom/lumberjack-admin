<?php

namespace Adeliom\Lumberjack\Admin\Fields\Medias;

use Extended\ACF\Fields\Image;

abstract class ImageField
{
    public const IMAGE = "image";

    /**
     * Image
     */
    public static function image(string $width = "", string $height = "", string $title = "Image", ?string $key = null): Image
    {
        return Image::make(__($title), $key ?? self::IMAGE)
            ->instructions(!empty($width) ? ("Ratio recommandé : " . $width . "x" . $height) : "")
            ->library("all")
            ->returnFormat('array');
    }
}
