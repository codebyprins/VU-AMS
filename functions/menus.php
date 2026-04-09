<?php

/**
 * Register the theme menus.
 *
 * @return void
 */
if (!function_exists('menus_setup')) :

    /**
     * Sets up theme menus and registers support for various WordPress features.
     */
    function menus_setup()
    {
        register_nav_menus(
            array(
                'primary_navigation' => __('Primary', 'vu-ams'),
            )
        );
    }

endif;

add_action('after_setup_theme', 'menus_setup');