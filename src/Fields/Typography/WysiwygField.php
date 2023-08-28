<?php

namespace Adeliom\Lumberjack\Admin\Fields\Typography;

use App\Hooks\Admin\WysiwygHooks;
use Extended\ACF\Fields\WysiwygEditor;

class WysiwygField extends WysiwygEditor
{
    public constWYSIWYG = "wysiwyg";

    public static function make(string $label = "Description", string|null $name = self::WYSIWYG): static
    {
        return parent::make($label, $name);
    }

    public function default(): static
    {
        $this->settings['tabs'] = "visual";
        $this->settings['toolbar'] = WysiwygHooks::TOOLBAR_DEFAULT;
        $this->settings['media_upload'] = false;
        return $this;
    }

    public function simple(): static
    {
        $this->settings['tabs'] = "visual";
        $this->settings['toolbar'] = WysiwygHooks::TOOLBAR_SIMPLE;
        $this->settings['media_upload'] = false;
        return $this;
    }
}