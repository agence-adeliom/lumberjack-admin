<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Helpers;

class Instructions
{
    /**
     * Returns image instructions text
     *
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function image(int $width, int $height): string
    {
        return (string) apply_filters('adeliom_image_instruction', sprintf(__("Ratio d'image recommandée :  %s pixels de largeur et %s de pixels de hauteur", 'adeliom'), $width, $height), $width, $height);
    }
}
