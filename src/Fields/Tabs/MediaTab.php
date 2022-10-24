<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Medias\MediaField;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Tab;

class MediaTab extends Tab
{
    private const TAB = "media_tab";

    public static function make(string $label = "Média", string|null $name = self::TAB): static
    {
        return new static($label, $name);
    }

    public function media(string $instructions = ""): Group
    {
        return MediaField::make($instructions);
    }

    public function image(string $instructions = ""): Group
    {
        return MediaField::make($instructions, [MediaField::HAS_IMAGE]);
    }

    public function video(string $instructions = ""): Group
    {
        return MediaField::make($instructions, [MediaField::HAS_VIDEO]);
    }
}
