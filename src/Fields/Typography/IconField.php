<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Text;

class IconField extends Text
{
    protected string|null $type = 'font-awesome';

    public const ICON = "icon";

    /**
     * Icône
     */
    public static function make(string $label = "Icône", ?string $name = null): static
    {
        return parent::make($label, $name ?? self::ICON)->iconSet()->returnFormat();
    }

    public function returnFormat(string $format = "object"): static
    {
        $this->settings['save_format'] = $format;
        return $this;
    }

    public function iconSet(array $iconSet = ["light", "thin"]): static
    {
        $this->settings['icon_sets'] = $iconSet;
        return $this;
    }
}