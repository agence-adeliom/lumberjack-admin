<?php

namespace Adeliom\Lumberjack\Admin;

use Adeliom\Lumberjack\Admin\Hooks\RestrictionsHooks;
use Adeliom\Lumberjack\Admin\Hooks\TemplateHooks;
use Rareloop\Lumberjack\Config;
use Rareloop\Lumberjack\Providers\ServiceProvider;

class AdminProvider extends ServiceProvider
{
    /**
     * @throws \JsonException
     */
    public function boot(Config $config): void
    {
        add_action('init', [TemplateHooks::class, "addBlockTemplateToPageTemplate"]);
        add_filter('use_block_editor_for_post_type', [TemplateHooks::class, "disabledGutenberg"], 10, 2);
        add_action('allowed_block_types_all', [RestrictionsHooks::class, "allowedBlock"], 10, 2);

        $gutenbergCategories = $config->get('gutenberg.categories', []);
        add_filter("block_categories_all", static function (array $categories, \WP_Block_Editor_Context $block_editor_context) use ($gutenbergCategories) {
            foreach ($categories as $index => $category) {
                if (array_key_exists($category["slug"], $gutenbergCategories)) {
                    unset($categories[$index]);
                }
            }
            return array_merge($categories, $gutenbergCategories);
        }, 10, 2);
    }
}
