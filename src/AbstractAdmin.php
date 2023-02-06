<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin;

use Symfony\Component\String\Slugger\AsciiSlugger;
use Traversable;
use Extended\ACF\Fields\Field;
use Extended\ACF\Location;

/**
 * Class AbstractAdmin
 * @package Adeliom\Lumberjack\Admin
 */
abstract class AbstractAdmin
{
    public const TITLE = 'abstract';
    public const IS_OPTION_PAGE = false;
    public const IS_SUB_OPTION_PAGE = false;
    public const PARENT_SLUG = null;

    /**
     * An list of fields
     * @return \ArrayIterator<int, Field>
     */
    abstract public static function getFields(): Traversable;

    /**
     * An list containing 'rule groups' where each 'rule group' is an array containing 'rules'. Each group is considered an 'or', and each rule is considered an 'and'.
     * @return \ArrayIterator<int, Location>
     */
    public static function getLocation(): Traversable
    {
        if (function_exists('acf_add_options_page') && static::IS_OPTION_PAGE) {
            yield Location::where('options_page', static::getSlug());
        }

        return [];
    }

    /**
     * Get the admin block style
     * @return string
     */
    public static function getStyle(): string
    {
        return "seamless";
    }

    /**
     * Determines the position on the edit screen. Defaults to acf_after_title. Choices of 'acf_after_title', 'normal' or 'side'
     * @return string
     */
    public static function getPosition(): string
    {
        return "acf_after_title";
    }

    /**
     * Determines where field labels are places in relation to fields. Defaults to 'top'. Choices of 'top' (Above fields) or 'left' (Beside fields)
     * @return string
     */
    public static function getLabelPlacement(): string
    {
        return "top";
    }

    /**
     * Determines where field instructions are places in relation to fields. Defaults to 'label'. Choices of 'label' (Below labels) or 'field' (Below fields)
     * @return string
     */
    public static function getInstructionPlacement(): string
    {
        return "label";
    }

    /**
     * An array of elements to hide on the screen
     * @return array
     */
    public static function getHideOnScreen(): array
    {
        return [
            'the_content',
            'excerpt',
            'discussion',
            'comments',
            'slug',
            'author',
            'format',
            'categories',
            'tags',
            'send-trackbacks',
            'featured_image'
        ];
    }

    /**
     * Field groups are shown in order from lowest to highest. Defaults to 0
     * @return int
     */
    public static function getMenuOrder(): int
    {
        return 0;
    }

    /**
     * Register option page settings
     * @return array
     */
    public static function setupOptionPage(): array
    {
        return [
            'page_title' => static::TITLE,
            'menu_title' => static::TITLE,
            'menu_slug'  => static::getSlug(),
            'capability' => 'edit_theme_options',
            'autoload' => true,
            'parent_slug' => static::PARENT_SLUG,

        ];
    }

    /**
     * Return the slug of your admin
     * @return string
     */
    public static function getSlug(): string
    {
        return (new AsciiSlugger())->slug(static::TITLE)->toString();
    }

    /**
     * Register the admin Block
     * @return void
     */
    public static function register(): void
    {
        self::__add(__CLASS__, static::class);

        if (function_exists('acf_add_options_page') && static::IS_OPTION_PAGE) {
            $options = static::setupOptionPage();
            acf_add_options_page($options);
        }

        if (function_exists('acf_add_options_sub_page') && static::IS_OPTION_PAGE && static::IS_SUB_OPTION_PAGE) {
            $options = static::setupOptionPage();
            acf_add_options_sub_page($options);
        }

        register_extended_field_group([
            'title' => static::TITLE,
            'style' => static::getStyle(),
            'fields' => iterator_to_array(static::getFields(), false),
            'location' => iterator_to_array(static::getLocation(), false),
            'position' => static::getPosition(),
            'label_placement' => static::getLabelPlacement(),
            'instruction_placement' => static::getInstructionPlacement(),
            'hide_on_screen' => static::getHideOnScreen(),
            'menu_order' => static::getMenuOrder(),
        ]);
    }

    public static function __add($class, $c)
    {
        $reflection = new \ReflectionClass($class);
        $constantsForced = $reflection->getConstants();
        foreach ($constantsForced as $constant => $value) {
            if (constant("$c::$constant") === "abstract") {
                throw new \RuntimeException("$constant in not defined  in " . (string) $c);
            }
        }
    }
}
