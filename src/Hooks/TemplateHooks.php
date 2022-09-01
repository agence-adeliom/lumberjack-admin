<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Hooks;

use Adeliom\Lumberjack\Admin\Helpers\GutenbergBlock;
use Rareloop\Lumberjack\Facades\Config;

class TemplateHooks
{
    /**
     * Set custom blocks template from config files to page templates
     * https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
     */
    public static function addBlockTemplateToPageTemplate(): void
    {
        $config = Config::get('gutenberg.templates', []);
        if (empty($config)) {
            return;
        }
        $settings = GutenbergBlock::getObjectSettings($_GET['post'] ?? null, $_GET['post_type'] ?? "post");
        if($settings) {
            if (!empty($settings["template"]) || !empty($settings["template_lock"])) {
                $postTypeObject = get_post_type_object($settings["post_type"]);
                foreach (['template', 'template_lock'] as $prop) {
                    if (isset($settings[$prop]) && $postTypeObject) {
                        $postTypeObject->{$prop} = $settings[$prop];
                    }
                }
            }
        }
    }

    /**
     * Disable Gutenberg on page template or post id specified in config file
     * key used : disable_gutenberg
     *
     * @param bool $canEdit
     * @param string|null $postType
     * @return bool
     */
    public static function disabledGutenberg(bool $canEdit, string $postType = null): bool
    {
        $config = Config::get('gutenberg.templates', []);

        if (empty($config)) {
            return $canEdit;
        }

        $settings = GutenbergBlock::getObjectSettings($_GET['post'] ?? null, $postType);
        if($settings){
            return $settings["enabled"] ?? $canEdit;
        }
        return $canEdit;
    }
}
