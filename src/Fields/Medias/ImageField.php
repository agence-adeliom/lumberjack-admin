<?php

namespace Adeliom\Lumberjack\Admin\Fields\Medias;

use Extended\ACF\Fields\Image;

class ImageField extends Image
{
    public constIMAGE = "image";

    public static function make(string $label = "Image", ?string $name = self::IMAGE): static
    {
        return parent::make($label, $name)
            ->library("all")
            ->returnFormat('array');
    }

    public function ratio(int $width = null, int $height = null): static
    {
        if (null !== $width && null !== $height) {
            $this->settings['instructions'] = "Ratio recommandé : " . $width . "x" . $height . "px";
        } elseif (null !== $width) {
            $this->settings['instructions'] = "Largeur recommandée : " . $width . "px";
        } elseif (null !== $height) {
            $this->settings['instructions'] = "Hauteur recommandée : " . $height . "px";
        }
        return $this;
    }
}