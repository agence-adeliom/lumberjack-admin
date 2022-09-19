<?php

namespace App\Admin\Fields\Choices;

use Extended\ACF\Fields\TrueFalse;

class TrueFalseField extends TrueFalse
{
    /**
     * Vrai / Faux
     */
    public static function make(string $label = "", ?string $name = null): static
    {
        return parent::make($label, $name)
            ->stylisedUi()
            ;
    }
}
