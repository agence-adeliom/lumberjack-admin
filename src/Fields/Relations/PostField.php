<?php

namespace Adeliom\Lumberjack\Admin\Fields\Relations;

use Extended\ACF\Fields\PostObject;

class PostField extends PostObject
{
    public constPOST = 'post';

    public static function make(string $label = "Page", string|null $name = self::POST): static
    {
        return parent::make($label, $name)
            ->returnFormat('object')
            ->allowNull();
    }
}