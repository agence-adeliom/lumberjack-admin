<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin;

use Traversable;
use Extended\ACF\Fields\Field;
use Extended\ACF\Location;

/**
 * Class AbstractAdmin
 * @package Adeliom\Lumberjack\Admin
 */
abstract class AbstractAdmin
{
    /**
     * Register the admin Block
     * @return void
     */
    public static function register(): void
    {
        if (function_exists('acf_add_options_page') && static::hasOptionPage()) {
            $options = static::setupOptionPage();
            acf_add_options_page($options);
        }

        register_extended_field_group([
            'title' => static::getTitle(),
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

    /**
     * Visible in metabox handle
     * @return string
     */
    abstract public static function getTitle(): string;

    /**
     * An list of fields
     * @return \ArrayIterator<int, Field>
     */
    abstract public static function getFields(): Traversable;

    /**
     * An list containing 'rule groups' where each 'rule group' is an array containing 'rules'. Each group is considered an 'or', and each rule is considered an 'and'.
     * @return \ArrayIterator<int, Location>
     */
    abstract public static function getLocation(): Traversable;

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
            'page_attributes',
            'categories',
            'tags',
            'send-trackbacks',
            'featured_image',
            //'permalink',
            //'revisions',
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
     * Register has option page
     * @return bool
     */
    public static function hasOptionPage(): bool
    {
        return false;
    }

    /**
     * Register option page settings
     * @return array
     */
    public static function setupOptionPage(): array
    {
        return [
            'page_title' => "Options",
            'menu_title' => 'Options',
            'menu_slug'  => "options",
            'capability' => 'edit_theme_options',
            'autoload' => true
        ];
    }
}
