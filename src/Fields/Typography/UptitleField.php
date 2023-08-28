<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Text;

class UptitleField extends Text
{
    public constUP_TITLE = "uptitle";

    public static function make(string $label = "Sur-titre", string|null $name = self::UP_TITLE): static
    {
        return parent::make($label, $name);
    }
}