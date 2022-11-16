<?php

namespace Adeliom\Lumberjack\Admin\Fields\Layout;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\TrueFalse;

class LayoutField
{
    private const MEDIA_POSITION = "media_position";
    private const DARK_MODE = "dark_mode";

    private const MARGIN = "margin";

    public const MARGIN_SIZES = "sizes";
    public const MARGIN_TOP_REMOVE = "top_remove";
    public const MARGIN_BOTTOM_REMOVE = "bottom_remove";

    public static function darkMode(): TrueFalse
    {
        return TrueFalse::make(__('Dark mode'), self::DARK_MODE)
            ->instructions('Activer le fond sombre pour ce bloc')
            ->stylisedUi();
    }

    public static function mediaPosition(array $choices = [
        'left'   => 'À gauche',
        'right'  => 'À droite'
    ]): RadioButton
    {
        return RadioButton::make(__('Position du média'), self::MEDIA_POSITION)
            ->choices($choices)
            ->defaultValue("left")
            ->required();
    }

    public static function margin(array $fields = [
        self::MARGIN_SIZES,
        self::MARGIN_TOP_REMOVE,
        self::MARGIN_BOTTOM_REMOVE
    ]): Group
    {

        $fieldsGroup = [];

        if (in_array(self::MARGIN_SIZES, $fields)) {
            $fieldsGroup[] = Select::make("Taille des marges", self::MARGIN_SIZES)
                ->choices([
                    "small" => "Petite",
                    "large" => "Grande"
                ])
                ->defaultValue("large")
                ->instructions("");
        }

        if (in_array(self::MARGIN_TOP_REMOVE, $fields)) {
            $fieldsGroup[] = TrueFalse::make("Suppression marge haute", self::MARGIN_TOP_REMOVE)
                ->stylisedUi()
                ->instructions("");
        }

        if (in_array(self::MARGIN_BOTTOM_REMOVE, $fields)) {
            $fieldsGroup[] = TrueFalse::make("Suppression marge basse", self::MARGIN_BOTTOM_REMOVE)
                ->stylisedUi()
                ->instructions("");
        }

        return Group::make("Marges", self::MARGIN)->fields($fieldsGroup);
    }
}
