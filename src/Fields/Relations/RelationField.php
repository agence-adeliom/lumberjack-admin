<?php

namespace Adeliom\Lumberjack\Admin\Fields\Relations;

use Extended\ACF\Fields\Relationship;

class RelationField extends Relationship
{
    private const POST = 'post';

    public static function make(string $label = "Page", string|null $name = self::POST): static
    {
        return parent::make($label, self::POST)
            ->returnFormat('object');
    }
}
