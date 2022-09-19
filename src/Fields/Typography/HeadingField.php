<?php

namespace App\Admin\Fields\Typography;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;

class HeadingField extends Text
{
    public const TAG = "tag";
    public const TITLE = "title";
    public const CONTENT = "content";

    /**
     * Titre
     */
    public static function make(string $label = "Titre", ?string $name = null): static
    {
        return parent::make($label, $name ?? self::TITLE);
    }

    /**
     * Tag HTML
     */
    public static function tag(array $choices = [], string $instructions = "Choisir un tag HTML"): Select
    {
        $defaultChoices = [
            "div" => "Aucun",
            "h1" => "h1",
            "h2" => "h2",
            "h3" => "h3",
            "h4" => "h4",
            "h5" => "h5"
        ];

        if (!count($choices)) {
            $choices = $defaultChoices;
        }

        return Select::make("Tag HTML", self::TAG)
            ->choices($choices)
            ->defaultValue("div")
            ->instructions($instructions);
    }

    /**
     * Groupe qui contient Tag HTML + Titre
     */
    public static function group(string $title = "Titre"): Group
    {
        $fields = [
            self::tag(),
            self::make($title, self::CONTENT)
        ];

        return Group::make("Titre", self::TITLE)
            ->fields($fields)
            ;
    }
}
