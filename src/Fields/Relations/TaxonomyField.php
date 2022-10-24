<?php

namespace Adeliom\Lumberjack\Admin\Fields\Relations;

use Extended\ACF\Fields\Taxonomy;

class TaxonomyField extends Taxonomy
{
    private const CATEGORY = 'category';

    public static function make(string $label = "Catégorie", string|null $name = self::CATEGORY): static
    {
        return parent::make(__($label), $name)
            ->addTerm(false)
            ->loadTerms(false)
            ->saveTerms(true)
            ->appearance('select')
            ->returnFormat('object');
    }
}
