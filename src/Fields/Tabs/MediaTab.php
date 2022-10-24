<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Medias\MediaField;
use Extended\ACF\Fields\Tab;

class MediaTab extends Tab
{
    private const TAB = "media_tab";

    public static function make(string $label = "Média", string|null $name = self::TAB): static
    {
        return new static($label, $name);
    }

    public static function media(string $instructions = ""): \Generator
    {
        return self::media($instructions);
    }

    public static function image(string $instructions = ""): \Generator
    {
        return self::media($instructions, [MediaField::HAS_IMAGE]);
    }

    public static function video(string $instructions = ""): \Generator
    {
        return self::media($instructions, [MediaField::HAS_VIDEO]);
    }
}
