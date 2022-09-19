<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Medias\MediaField;
use Extended\ACF\Fields\Tab;

class MediaTab
{
    private const TAB = "media_tab";

    public static function make(string $instructions = ""): \Generator
    {
        yield Tab::make('Média', self::TAB);
        yield MediaField::media($instructions);
    }
}
