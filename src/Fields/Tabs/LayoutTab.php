<?php

namespace Adeliom\Lumberjack\Admin\Fields\Tabs;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;

class LayoutTab
{
    private const TAB = "layout_tab";

    public const MEDIA_POSITION = "media_position";
    public const DARK_MODE = "dark_mode";

    public const MARGIN = "margin";

    private const MARGIN_TOP_REMOVE = "top_remove";
    private const MARGIN_BOTTOM_REMOVE = "bottom_remove";

    public static function make(array $includes = []): \Generator
    {
        yield Tab::make("Mise en page", self::TAB);

        if (in_array(self::MEDIA_POSITION, $includes)) {
            yield RadioButton::make(__('Position du média'), self::MEDIA_POSITION)
                ->choices([
                    'left'   => 'À gauche',
                    'right'  => 'À droite',
                    'bottom'  => 'En bas',
                    'top'  => 'En haut'
                ])
                ->defaultValue("left")
                ->required();
        }

        if (in_array(self::DARK_MODE, $includes)) {
            yield TrueFalse::make(__('Dark mode'), self::DARK_MODE)
                ->instructions('Activer le fond sombre pour ce bloc')
                ->stylisedUi();
        }

        if (in_array(self::MARGIN, $includes)) {
            yield Group::make("Marges", self::MARGIN)
                ->fields([
                    TrueFalse::make("Suppression marge haute", self::MARGIN_TOP_REMOVE)
                        ->stylisedUi()
                        ->instructions(""),
                    TrueFalse::make("Suppression marge basse", self::MARGIN_BOTTOM_REMOVE)
                        ->stylisedUi()
                        ->instructions("")
                ]);
        }
    }
}
