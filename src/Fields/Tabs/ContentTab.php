<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Tabs\Traits\Fields;
use Extended\ACF\Fields\Tab;

class ContentTab extends Tab
{
    use Fields;

    private const TAB = "content_tab";

    public static function make(string $label = "Contenu", string|null $name = self::TAB): static
    {
        return parent::make($label, $name);
    }
}
