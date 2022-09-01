<?php

namespace Adeliom\Lumberjack\Admin\Fields\Choices;

use Extended\ACF\Fields\Field;
use Extended\ACF\Fields\TrueFalse;

abstract class TrueFalseField extends TrueFalse
{
    /**
     * Vrai / Faux
     */
    public static function make(string $label = "Vidéo youtube ?", ?string $name = null): static
    {
        return parent::make($label, $name)
            ->stylisedUi()
            ;
    }
}
