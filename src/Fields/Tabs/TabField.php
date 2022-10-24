<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Tabs\Traits\Fields;
use Extended\ACF\Fields\Tab;

class TabField extends Tab
{
    use Fields;

    public static function make(string $label, string|null $name = null): static
    {
        return new static($label, $name);
    }
}
