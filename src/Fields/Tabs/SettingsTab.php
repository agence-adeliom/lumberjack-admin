<?php

namespace App\Admin\Fields\Tabs;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;

class SettingsTab
{
    private const TAB = "settings_tab";

    public const ANCHOR = "anchor";

    public static function make(array $includes = []): \Generator
    {
        yield Tab::make("Paramètres", self::TAB);

        if (in_array(self::ANCHOR, $includes)) {
            yield Text::make("Ancre", self::ANCHOR)
                ->instructions("Ajouter une ancre pour accéder à la section au clic sur un bouton.");
        }
    }
}
