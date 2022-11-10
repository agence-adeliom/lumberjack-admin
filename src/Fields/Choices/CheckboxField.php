<?php

namespace Adeliom\Lumberjack\Admin\Fields\Choices;

use Extended\ACF\Fields\Checkbox;

class CheckboxField extends Checkbox
{
    public static function make(string $label = "", ?string $name = null): static
    {
        return parent::make($label, $name);
    }
}
