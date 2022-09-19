<?php

namespace App\Admin\Fields;

use Extended\ACF\Fields\Relationship;

class RelationField extends Relationship
{
    public const POST = 'post';

    public static function post(string $title = "", string $key = "", $postTypes = []): static
    {
        return parent::make($title, !empty($key) ? $key : self::POST)
            ->postTypes($postTypes)
            ->returnFormat('object');
    }
}
