<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Textarea;

class TextareaField extends Textarea
{
    public const DESCRIPTION = "description";

    public static function make(string $label = "Description", string|null $name = self::DESCRIPTION): static
    {
        return parent::make($label, $name);
    }
}