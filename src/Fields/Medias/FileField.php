<?php

namespace App\Admin\Fields\Medias;

use Extended\ACF\Fields\File;

class FileField extends File
{
    public const PDF = "pdf";

    public static function pdf(string $title = "PDF", string $key = "", string $instructions = ""): static
    {
        return parent::make(__($title), !empty($key) ? $key : self::PDF)
            ->instructions($instructions)
            ->mimeTypes(['pdf'])
            ->library("all")
            ->returnFormat('array');
    }
}
