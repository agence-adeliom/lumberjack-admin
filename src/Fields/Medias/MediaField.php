<?php

namespace Adeliom\Lumberjack\Admin\Fields\Medias;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\TrueFalse;

abstract class MediaField
{
    public const HAS_IMAGE = "image";
    public const HAS_VIDEO = "video";

    public const MEDIA = "media";

    public const TYPE = "type";
    public const FIT_CONTAIN = "fit_contain";
    public const POSITION = "position";

    public const POSITION_TOP = "top";
    public const POSITION_BOTTOM = "bottom";
    public const POSITION_CENTER = "center";

    /**
     * Groupe média : Choix entre vidéo ou image
     */
    public static function media(array $includes = [
        self::HAS_IMAGE,
        self::HAS_VIDEO,
    ], bool $handleWidth = false)
    {

        $choices = [];

        $hasImage = in_array(self::HAS_IMAGE, $includes, true);
        $hasVideo = in_array(self::HAS_VIDEO, $includes, true);

        if ($hasImage) {
            $choices[self::HAS_IMAGE] = "Image";
        }

        if ($hasVideo) {
            $choices[self::HAS_VIDEO] = "Vidéo";
        }

        $fields = [
            Select::make("Type", self::TYPE)
                ->choices($choices)
                ->instructions("Choisir le type de média")
                ->required()
        ];

        if ($handleWidth) {
            $fields = array_merge($fields, [
                TrueFalse::make("Image largeur auto", self::FIT_CONTAIN)
                    ->instructions("L'image s'adapte à la taille du bloc")
                    ->stylisedUi()
                    ->conditionalLogic([
                        ConditionalLogic::where(self::TYPE, "==", self::HAS_IMAGE)
                    ]),

                Select::make("Position de l'image", self::POSITION)
                    ->choices([
                        self::POSITION_TOP => "En haut",
                        self::POSITION_BOTTOM => "En bas",
                        self::POSITION_CENTER => "Centrée",
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where(self::FIT_CONTAIN, "==", 1)
                    ])
            ]);
        }

        if ($hasImage) {
            $imageField = ImageField::image()
            ->conditionalLogic([
                ConditionalLogic::where(self::TYPE, "==", self::HAS_IMAGE),
            ]);

            $fields[] = $imageField;
        }

        if ($hasVideo) {
            $videoField = VideoField::video()->conditionalLogic([
                ConditionalLogic::where(self::TYPE, "==", self::HAS_VIDEO),
            ]);

            $fields[] = $videoField;
        }

        return Group::make("Média", self::MEDIA)
            ->fields($fields);
    }
}
