<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Hooks;

use Adeliom\Lumberjack\Admin\Helpers\GutenbergBlock;
use Rareloop\Lumberjack\Facades\Config;
use WP_Block_Editor_Context;

class RestrictionsHooks
{
    private static function isRegex(string $regex)
    {
        return preg_match("/^\/[\s\S]+\/$/", $regex);
    }

    private static function isExcludePattern(string $pattern)
    {
        return strpos($pattern, '!') === 0;
    }

    private static function isWildcardPattern(string $pattern)
    {
        return strpos($pattern, '*') == (strlen($pattern) - 1);
    }

    private static function match(string $blockName, string $pattern): bool
    {
        $isExcludePattern = self::isExcludePattern($pattern);
        if ($isExcludePattern) {
            $pattern = substr($pattern, 1);
        }

        if (self::isRegex($pattern)) {
            $match = (bool) preg_match($pattern, $blockName);
            return !$isExcludePattern ? $match : !$match;
        }

        $isWildcardPattern = self::isWildcardPattern($pattern);
        if ($isWildcardPattern) {
            $pattern = str_replace("*", "", $pattern);
            return !$isExcludePattern ? (strpos($blockName, $pattern) === 0) : !(strpos($blockName, $pattern) === 0);
        }

        return !$isExcludePattern ? ($blockName === $pattern) : !($blockName === $pattern);
    }

    /**
     * Disable gutenberg blocks from post type
     * Restriction are defined in config files
     *
     * @param bool|array $allowed_block_types
     * @param WP_Block_Editor_Context $post
     * @return array
     */
    public static function allowedBlock($allowed_block_types, WP_Block_Editor_Context $postContext): array
    {
        $post = $postContext->post;
        $config = Config::get('gutenberg.templates', []);
        if (empty($config)) {
            return $allowed_block_types;
        }

        $settings = Config::get('gutenberg.settings', null);
        $disableBlockPatterns = $settings["disable_blocks"] ?? false;
        if ($disableBlockPatterns && !is_array($disableBlockPatterns)) {
            $disableBlockPatterns = [$disableBlockPatterns];
        }

        $allBlock = GutenbergBlock::getAllBlocksList();
        $postSettings = GutenbergBlock::getObjectSettings($post);
        $blocks = [];
        foreach ($allBlock as $block) {
            $blocks[$block] = true;
        }


        foreach ($disableBlockPatterns as $pattern) {
            $isExcludePattern = self::isExcludePattern($pattern);
            foreach ($allBlock as $block) {
                if (self::match($block, $pattern) && !$isExcludePattern) {
                    $blocks[$block] = false;
                } elseif (!self::match($block, $pattern) && $isExcludePattern) {
                    $blocks[$block] = true;
                }
            }
        }


        foreach ($postSettings["blocks"] as $pattern) {
            $isExcludePattern = self::isExcludePattern($pattern);
            foreach ($allBlock as $block) {
                if (self::match($block, $pattern) && !$isExcludePattern) {
                    $blocks[$block] = true;
                } elseif (!self::match($block, $pattern) && $isExcludePattern) {
                    $blocks[$block] = false;
                }
            }
        }

        return array_keys(array_filter($blocks));
    }
}
