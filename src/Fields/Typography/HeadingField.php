<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;

class HeadingField extends Text
{
    private const TAG = "tag";
    private const TITLE = "title";
    private const CONTENT = "content";

    public static function make(string $label = "Titre", string|null $name = self::TITLE): static
    {
        return new static($label, $name);
    }

    public static function tag(array $choices = [], string $instructions = "Choisir un tag HTML"): Group
    {
        $fields = [
            self::htmlTag($choices, $instructions),
            self::make("Titre", self::CONTENT)
        ];

        return Group::make("Titre", self::TITLE)
            ->fields($fields);
    }

    private static function htmlTag(array $choices = [], string $instructions = ""): Select
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
}
