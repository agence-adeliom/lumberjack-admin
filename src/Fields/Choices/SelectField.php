<?php

namespace Adeliom\Lumberjack\Admin\Fields\Choices;

use Extended\ACF\Fields\Select;

class SelectField extends Select
{
    public static function make(string $label = "", ?string $name = null): static
    {
        return parent::make($label, $name);
    }
}
