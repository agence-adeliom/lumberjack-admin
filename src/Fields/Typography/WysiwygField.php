<?php

namespace App\Admin\Fields\Typography;

use App\Hooks\Admin\WysiwygHooks;
use Extended\ACF\Fields\WysiwygEditor;

class WysiwygField extends WysiwygEditor
{
    public const WYSIWYG = "wysiwyg";

    public static function default(string $title = "Description", string $instructions = "", string $key = ""): static
    {
        return parent::make($title, !empty($key) ? $key : self::WYSIWYG)
            ->tabs('visual')
            ->toolbar(WysiwygHooks::TOOLBAR_DEFAULT)
            ->mediaUpload(false)
            ->instructions($instructions);
    }

    public static function simple(string $title = "Description", string $instructions = "", ?string $key = ""): static
    {
        return parent::make($title, !empty($key) ? $key : self::WYSIWYG)
            ->tabs('visual')
            ->toolbar(WysiwygHooks::TOOLBAR_SIMPLE)
            ->mediaUpload(false)
            ->instructions($instructions);
    }
}
