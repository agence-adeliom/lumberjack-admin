<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Textarea;

class TextareaField extends Textarea
{
    private const DESCRIPTION = "description";

    public static function make(string $label = "Description", string|null $name = self::DESCRIPTION): static
    {
        return new static($label, $name);
    }
}
