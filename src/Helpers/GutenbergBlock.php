<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Helpers;

use Rareloop\Lumberjack\Facades\Config;

class GutenbergBlock
{
    /**
     * @var string
     */
    public const CORE_BLOCK_PREFIX = 'core';

    /**
     * @var string
     */
    public const ACF_BLOCK_PREFIX = 'acf';

    /**
     * Get a array of all block names prefixed by core/*
     * @return array
     */
    public static function getCoreBlocksList(): array
    {
        return self::getBlocksListWithPrefix(self::CORE_BLOCK_PREFIX . '/');
    }

    public static function isAlreadyRegistered(string $name): bool
    {
        return in_array($name, self::getAllBlocksList(), true);
    }

    /**
     * Get a array of all block names prefixed by core/*
     *
     * @param string $prefix block prefix to retrieve list
     * @return array of block keys by prefix
     */
    protected static function getBlocksListWithPrefix(string $prefix): array
    {
        $registeredBlocks = self::getAllBlocksList();
        $blocks = [];

        foreach ($registeredBlocks as $blockName) {
            if (str_starts_with($blockName, $prefix)) {
                $blocks[] = $blockName;
            }
        }

        return $blocks;
    }

    /**
     * Get all Gutenberg defined blocks
     *
     * @return array
     */
    public static function getAllBlocksList(): array
    {
        $registry = \WP_Block_Type_Registry::get_instance();
        return array_values(array_keys($registry->get_all_registered()));
    }

    /**
     * Get a array of all block names prefixed by acf/*
     * @return array
     */
    public static function getAcfBlocksList(): array
    {
        return self::getBlocksListWithPrefix(self::ACF_BLOCK_PREFIX . '/');
    }

    /**
     * @param int|\WP_Post $post
     * @return array|null
     */
    public static function getObjectSettings($post, $postType = null): ?array
    {
        $config = Config::get('gutenberg.templates', []);
        if (empty($config)) {
            return null;
        }

        if (!$postType) {
            $postType = $_GET['post_type'] ?? "post";
        }

        $post = get_post($post);

        $wildcardSetting = $config["*"] ?? null;
        $currentPostId = $post->ID ?? null;
        $currentTemplate = get_page_template_slug($post);
        $currentPostType = get_post_type($post) ?: $postType;

        $settings = [
            "post_id" => $currentPostId,
            "post_template" => $currentTemplate,
            "post_type" => $currentPostType,
            "enabled" => true,
            "blocks" => [],
            "template" => null,
            "template_lock" => null
        ];

        if ($wildcardSetting) {
            self::mergeSettings($wildcardSetting, $settings);
        }

        if ((isset($config[$currentPostType]))) {
            self::mergeSettings($config[$currentPostType], $settings);
        }

        if ((isset($config[$currentTemplate]))) {
            self::mergeSettings($config[$currentTemplate], $settings);
        }

        if ((isset($config[$currentPostId]))) {
            self::mergeSettings($config[$currentPostId], $settings);
        }

        $pageClass = sprintf("%s-%s", $postType, $currentPostId);
        if ((isset($config[$pageClass]))) {
            self::mergeSettings($config[$pageClass], $settings);
        }

        return $settings;
    }

    /**
     * @param array|bool $config
     * @param array $settings
     * @return void
     */
    private static function mergeSettings($config, array &$settings)
    {
        if (is_bool($config)) {
            $settings["enabled"] = $config;
            return;
        }
        if (!empty($config["blocks"])) {
            if (is_string($config["blocks"])) {
                $settings["blocks"][] = $config["blocks"];
            } elseif (is_array($config["blocks"])) {
                $settings["blocks"] = array_merge($settings["blocks"], $config["blocks"]);
            }
        }
        if (!empty($config["template"])) {
            $settings["template"] = $config["template"];
        }
        if (!empty($config["template_lock"])) {
            $settings["template_lock"] = $config["template_lock"];
        }
    }
}
