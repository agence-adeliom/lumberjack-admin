<?php

namespace App\Admin\Fields;

use App\Admin\Fields\Choices\TrueFalseField;
use App\Admin\Fields\Medias\ImageField;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Text;

class VideoField
{
    public const VIDEO = "video";
    public const THUMBNAIL = "thumbnail";
    public const VIDEO_FILE = "file";
    public const IS_YOUTUBE = "is_youtube";
    public const ID_YOUTUBE = "id";

    /**
     * Vidéo
     */
    public static function video(): Group
    {
        return Group::make(__("Vidéo"), self::VIDEO)
            ->fields([

                ImageField::make(__("Vignette"), self::THUMBNAIL)
                    ->required(),

                TrueFalseField::make("Vidéo youtube ?", self::IS_YOUTUBE),

                Text::make('Identifiant de la vidéo', self::ID_YOUTUBE)
                    ->conditionalLogic([
                        ConditionalLogic::where(self::IS_YOUTUBE, "==", 1)
                    ]),

                File::make("Fichier", self::VIDEO_FILE)
                    ->mimeTypes(["mp4"])
                    ->returnFormat("url")
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::where(self::IS_YOUTUBE, "!=", 1),
                    ])

            ]);
    }
}
