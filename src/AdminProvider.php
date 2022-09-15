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
        $this->registerAdmin();
        $this->registerBlock();

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

    private function registerAdmin(): void
    {
        $adminPath = $this->app->basePath() . "/app/Admin";
        if (!file_exists($adminPath)) {
            return;
        }
        foreach ($this->getDirContents($adminPath) as $file) {
            include($file);
        }
        foreach (get_declared_classes() as $class) {
            if (str_contains($class, "App\Admin")) {
                try {
                    $classMeta = new \ReflectionClass($class);
                    if ($classMeta->isSubclassOf(AbstractAdmin::class)) {
                        $class::register();
                    }
                } catch (\ReflectionException $reflectionException) {
                }
            }
        }
    }

    private function registerBlock(): void
    {
        $adminPath = $this->app->basePath() . "/app/Block";
        if (!file_exists($adminPath)) {
            return;
        }
        foreach ($this->getDirContents($adminPath) as $file) {
            $info = pathinfo($file);
            if ($info['extension'] === "php") {
                include($file);
            }
        }

        foreach (get_declared_classes() as $class) {
            if (str_contains($class, "App\Blocks")) {
                try {
                    $classMeta = new \ReflectionClass($class);
                    if ($classMeta->isSubclassOf(AbstractBlock::class)) {
                        $instance = new $class();

                        if (!$instance->isValid() || !$instance->isEnabled()) {
                            unset($instance);
                            continue 1;
                        }

                        $instance->init();
                    }
                } catch (\ReflectionException $reflectionException) {
                }
            }
        }
    }

    /**
     * @param $path
     * @return array
     */
    private function getDirContents($path): array
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $php_files = new \RegexIterator($rii, '/\.php$/');

        $files = [];
        foreach ($rii as $file) {
            if (!$file->isDir()) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
