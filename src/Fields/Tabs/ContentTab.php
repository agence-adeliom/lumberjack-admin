<?php

namespace App\Admin\Fields\Tabs;

use Extended\ACF\Fields\Tab;

class ContentTab
{
    private const TAB = "content_tab";

    public static function make(): \Generator
    {
        yield Tab::make('Contenu', self::TAB);
    }
}
