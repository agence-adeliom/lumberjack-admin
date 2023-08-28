<?php

namespace Adeliom\Lumberjack\Admin\Fields\Medias;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;

class MediaField
{
    public const HAS_IMAGE = "image";
    public const HAS_VIDEO = "video";

    public constMEDIA = "media";
    public constTYPE = "type";

    /**
     * Groupe média : Choix entre vidéo ou image
     */
    public static function make(string $instructions = "", array $includes = [
        self::HAS_IMAGE,
        self::HAS_VIDEO,
    ]): Group
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

        if ($hasImage) {
            $imageField = ImageField::make()
            ->conditionalLogic([
                ConditionalLogic::where(self::TYPE, "==", self::HAS_IMAGE),
            ]);

            $fields[] = $imageField;
        }

        if ($hasVideo) {
            $videoField = VideoField::make()->conditionalLogic([
                ConditionalLogic::where(self::TYPE, "==", self::HAS_VIDEO),
            ]);

            $fields[] = $videoField;
        }

        return Group::make("Média", self::MEDIA)
            ->instructions($instructions)
            ->fields($fields);
    }

    public static function image(string $instructions = ""): Group
    {
        return Group::make("Média", self::MEDIA)
            ->instructions($instructions)
            ->fields([
                ImageField::make()->conditionalLogic([
                    ConditionalLogic::where(self::TYPE, "==", self::HAS_IMAGE),
                ])
            ]);
    }

    public static function video(string $instructions = ""): Group
    {
        return Group::make("Média", self::MEDIA)
            ->instructions($instructions)
            ->fields([
                VideoField::make()->conditionalLogic([
                    ConditionalLogic::where(self::TYPE, "==", self::HAS_VIDEO),
                ])
            ]);
    }
}