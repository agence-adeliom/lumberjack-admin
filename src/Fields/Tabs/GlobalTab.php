<?php

namespace App\Admin\Fields\Tabs;

use Extended\ACF\Fields\Tab;

class GlobalTab
{
    private const TAB = "global_tab";

    public static function make(): \Generator
    {
        yield Tab::make('Global', self::TAB);
    }
}
