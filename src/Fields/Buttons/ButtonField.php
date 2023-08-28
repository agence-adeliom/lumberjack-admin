<?php

namespace Adeliom\Lumberjack\Admin\Fields\Buttons;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;

class ButtonField extends Link
{
    public const BUTTON = "button";
    public const BUTTON_TYPE = "type";
    public const BUTTON_LINK = "link";

    public const BUTTONS = "buttons";
    public const BUTTON_ONE = "one";
    public const BUTTON_TWO = "two";


    public static function make(string $label = "Bouton", string|null $name = self::BUTTON): static
    {
        return parent::make($label, $name);
    }

    /**
     * Type de boutons
     */
    public function types(string $title = "Types", string|null $typeInstructions = "", string|null $name = self::BUTTON): Group
    {
        return Group::make($title, $name)
            ->fields([
                Select::make("Types", self::BUTTON_TYPE)
                    ->choices([
                        "primary"   => __("Primaire"),
                        "secondary" => __("Secondaire"),
                        "outline"   => __("Outline"),
                    ])
                    ->defaultValue("primary")
                    ->instructions($typeInstructions),
                self::make("Lien", self::BUTTON_LINK),
            ]);
    }

    /**
     * Groupe de deux boutons
     */
    public function group(bool $withType = false): Group
    {
        $fields = [
            self::make(__("Bouton principal"), self::BUTTON_ONE),
            self::make(__("Bouton secondaire"), self::BUTTON_TWO),
        ];

        if ($withType) {
            $fields = [
                self::types(__("Bouton principal"), "", self::BUTTON_ONE),
                self::types(__("Bouton secondaire"), "", self::BUTTON_TWO),
            ];
        }

        return Group::make(__("Boutons"), self::BUTTONS)->fields($fields);
    }
}