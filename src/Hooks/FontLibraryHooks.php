<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Hooks;

/**
 * Désactive la Font Library introduite par WordPress 7.0.
 *
 * Compatible WP < 7 : sans Font Library, remove_submenu_page() est un no-op et
 * $pagenow ne vaut jamais 'font-library.php', donc ces hooks sont sans effet.
 */
class FontLibraryHooks
{
    /**
     * Retire l'entrée de menu « Polices » (Font Library, WP 7.0) sous Apparence.
     */
    public static function removeFontLibraryMenu(): void
    {
        remove_submenu_page('themes.php', 'font-library.php');
    }

    /**
     * Bloque l'accès direct à la Font Library par URL (wp-admin/font-library.php).
     */
    public static function blockFontLibraryAccess(): void
    {
        global $pagenow;

        if ('font-library.php' === $pagenow) {
            wp_safe_redirect(admin_url());
            exit;
        }
    }
}