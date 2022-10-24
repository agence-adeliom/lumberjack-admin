<?php

namespace Adeliom\Lumberjack\Admin\Fields\Relations;

use Extended\ACF\Fields\PostObject;

class PostField extends PostObject
{
    private const POST = 'post';

    public static function make(string $label = "Page", string|null $name = self::POST): static
    {
        return parent::make($label, self::POST)
            ->returnFormat('object')
            ->allowNull();
    }
}
