<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;

abstract class TitleField extends Text
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

    public static function content(string $label = "Titre", ?string $name = null, ?string $instruction = null): static
    {
        $field = parent::make($label, $name ?? self::TITLE);
        if ($instruction) {
            $field->instructions($instruction);
        }
        return $field;
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
    public static function group(string $title = "Titre", ?string $titleInstructions = null): Group
    {
        $fields = [
            self::tag(),
            self::content($title, self::CONTENT, $titleInstructions)
        ];

        return Group::make("Titre", self::TITLE)
            ->fields($fields)
            ;
    }
}
