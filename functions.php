<?php
function vuams_enqueue_assets()
{
    // Dev server (hot reload)
    if (defined('WP_DEBUG') && WP_DEBUG) {
        // remove version to avoid browser blocking
        wp_enqueue_script(
            'vuams-js',
            'http://localhost:5173/scripts/app.js',
            [], // no version
            false, // no version
            true
        );
        wp_enqueue_style(
            'vuams-css',
            'http://localhost:5173/styles/app.css',
            [], // no version
            false // no version
        );
        return;
    }

    // Production build
    $theme_uri = get_template_directory_uri() . '/public';
    wp_enqueue_style(
        'vuams-css',
        $theme_uri . '/app.css',
        [],
        file_exists(get_template_directory() . '/public/app.css') ? filemtime(get_template_directory() . '/public/app.css') : false
    );
    wp_enqueue_script(
        'vuams-js',
        $theme_uri . '/app.js',
        [],
        file_exists(get_template_directory() . '/public/app.js') ? filemtime(get_template_directory() . '/public/app.js') : false,
        true
    );
}
add_action('wp_enqueue_scripts', 'vuams_enqueue_assets');
