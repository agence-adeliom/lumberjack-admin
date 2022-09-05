<?php

namespace Adeliom\Lumberjack\Admin\Fields\Buttons;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;

abstract class ButtonField
{
    public const BUTTON = "button";
    public const BUTTON_TYPE = "type";
    public const BUTTON_LINK = "link";

    public const BUTTONS = "buttons";
    public const BUTTON_ONE = "one";
    public const BUTTON_TWO = "two";

    /**
     * Lien du bouton
     */
    public static function link(string $title = "Bouton", string $key = self::BUTTON): Link
    {
        return Link::make($title, $key);
    }

    public static function types(string $title = "Types", $typeInstructions = ""): Group
    {
        return Group::make($title, self::BUTTON)
            ->fields([
                Select::make("Types", self::BUTTON_TYPE)
                    ->choices([
                        "primary"   => __("Primaire", 'lumberjack-admin'),
                        "secondary" => __("Secondaire", 'lumberjack-admin'),
                        "outline"   => __("Outline", 'lumberjack-admin'),
                    ])
                    ->defaultValue("primary")
                    ->instructions($typeInstructions),
                self::link("Lien", self::BUTTON_LINK),
            ]);
    }

    /**
     * Groupe de deux boutons
     */
    public static function group(bool $withType = false): Group
    {
        $fields = [
            self::link(__("Bouton principal", 'lumberjack-admin'), self::BUTTON_ONE),
            self::link(__("Bouton secondaire", 'lumberjack-admin'), self::BUTTON_TWO),
        ];

        if ($withType) {
            $fields = [
                self::types(__("Bouton 1", 'lumberjack-admin'), self::BUTTON_ONE),
                self::types(__("Bouton 2", 'lumberjack-admin'), self::BUTTON_TWO),
            ];
        }

        return Group::make(__("Boutons", 'lumberjack-admin'), self::BUTTONS)->fields($fields);
    }
}
