<?php

namespace Adeliom\Lumberjack\Admin\Fields\Medias;

use Extended\ACF\Fields\File;

class FileField extends File
{
    private const PDF = "pdf";

    public static function make(string $label = "Fichier", string|null $name = null): static
    {
        return parent::make($label, $name);
    }

    public function pdf(): static
    {
        $this->settings['name'] = self::PDF;
        $this->settings['mime_types'] = ["pdf"];
        $this->settings['library'] = "all";
        $this->settings['return_format'] = "array";
        return $this;
    }
}
