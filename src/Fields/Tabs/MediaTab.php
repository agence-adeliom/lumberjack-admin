<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Tabs\Traits\Fields;
use Extended\ACF\Fields\Tab;

class MediaTab extends Tab
{
    use Fields;

    public constTAB = "media_tab";

    public static function make(string $label = "Média", string|null $name = self::TAB): static
    {
        return parent::make($label, $name);
    }
}