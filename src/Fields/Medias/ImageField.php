<?php

namespace Adeliom\Lumberjack\Admin\Fields\Medias;

use Extended\ACF\Fields\Image;

class ImageField
{
    private const IMAGE = "image";

    public static function make(string $title = "Image", ?string $key = null, ?int $width = null, ?int $height = null): Image
    {

        $instructions = null;

        if (null !== $width && null !== $height) {
            $instructions = "Ratio recommandé : " . $width . "x" . $height . "px";
        } elseif (null !== $width) {
            $instructions = "Largeur recommandée : " . $width . "px";
        } elseif (null !== $height) {
            $instructions = "Hauteur recommandée : " . $height . "px";
        }

        $imageField = Image::make(__($title), $key ?? self::IMAGE)
            ->library("all")
            ->returnFormat('array');

        if ($instructions) {
            $imageField = $imageField->instructions($instructions);
        }

        return $imageField;
    }
}
