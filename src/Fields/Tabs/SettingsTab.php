<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Adeliom\Lumberjack\Admin\Fields\Tabs\Traits\Fields;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;

class SettingsTab extends Tab
{
    use Fields;

    private const TAB = "settings_tab";
    private const ANCHOR = "anchor";

    public static function make(string $label = "Paramètres", string|null $name = self::TAB): static
    {
        return parent::make($label, $name);
    }

    public static function anchor(): Text
    {
        return Text::make("Ancre", self::ANCHOR)
            ->instructions("Ajouter une ancre pour accéder à la section au clic sur un bouton.");
    }
}
