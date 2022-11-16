<?php

namespace Adeliom\Lumberjack\Admin\Fields\Choices;

use Extended\ACF\Fields\RadioButton;

class RadioField extends RadioButton
{
    public static function make(string $label = "", ?string $name = null): static
    {
        return parent::make($label, $name);
    }
}
