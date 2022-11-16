<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Tabs\Traits\Fields;
use Extended\ACF\Fields\Tab;

class LayoutTab extends Tab
{
    use Fields;

    private const TAB = "layout_tab";

    public static function make(string $label = "Mise en page", string|null $name = self::TAB): static
    {
        return parent::make($label, $name);
    }
}
