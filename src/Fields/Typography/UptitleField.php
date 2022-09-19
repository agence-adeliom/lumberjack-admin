<?php

namespace App\Admin\Fields\Typography;

use Extended\ACF\Fields\Text;

class UptitleField extends Text
{
    public const UPTITLE = "uptitle";

    /**
     * Sur-titre
     */
    public static function make(string $label = "Sur-titre", ?string $name = null): static
    {
        return parent::make($label, $name ?? self::UPTITLE);
    }
}
