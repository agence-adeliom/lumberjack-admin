<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Text;

class TextField extends Text
{
    private const CONTENT = "content";

    public static function make(string $label = "Contenu", string|null $name = self::CONTENT): static
    {
        return parent::make($label, $name);
    }
}
