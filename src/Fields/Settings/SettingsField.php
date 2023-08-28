<?php

namespace Adeliom\Lumberjack\Admin\Fields\Settings;

use Extended\ACF\Fields\Text;

class SettingsField
{
    public constANCHOR = "anchor";

    public static function anchor(): Text
    {
        return Text::make("Ancre", self::ANCHOR)
            ->instructions("Ajouter une ancre pour accéder à la section au clic sur un bouton.");
    }
}