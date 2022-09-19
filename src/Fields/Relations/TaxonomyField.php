<?php

namespace Adeliom\Lumberjack\Admin\Fields\Relations;

use Extended\ACF\Fields\Taxonomy;

class TaxonomyField extends Taxonomy
{
    public const CATEGORY = 'category';

    public static function category(string $title = "", string $taxonomy = "", string $key = self::CATEGORY): static
    {
        return parent::make(__($title), $key)
            ->addTerm(false)
            ->loadTerms(false)
            ->saveTerms(false)
            ->taxonomy($taxonomy)
            ->appearance('select')
            ->returnFormat('object');
    }
}
