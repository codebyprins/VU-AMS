<?php
// Enqueue Tailwind
// function vu_ams_enqueue_styles()
// {
//     wp_enqueue_style(
//         'vu-ams-tailwind',
//         get_stylesheet_directory_uri() . '/resources/styles/app.css',
//         [],
//         '1.0'
//     );
// }
// add_action('wp_enqueue_scripts', 'vu_ams_enqueue_styles');

function mytheme_register_custom_blocks()
{
    $blocks = glob(get_template_directory() . '/blocks/*.php');

    foreach ($blocks as $block_file) {
        require $block_file;
    }
}
add_action('init', 'mytheme_register_custom_blocks');

function load_vite_assets()
{
    // Dev mode detection: use WP_DEBUG or a constant you define
    $is_dev = defined('WP_DEBUG') && WP_DEBUG;

    if ($is_dev) {
        // Load directly from Vite dev server
        $vite_server = 'http://localhost:5173';

        wp_enqueue_script(
            'theme-js',
            $vite_server . '/resources/scripts/app.js',
            [],
            null,
            true
        );

        wp_enqueue_style(
            'theme-css',
            $vite_server . '/resources/styles/app.css',
            [],
            null
        );

        return;
    }

    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'theme-js') {
            return str_replace('<script ', '<script crossorigin ', $tag);
        }
        return $tag;
    }, 10, 2);

    // Production: load built files via manifest
    $manifest_path = get_theme_file_path('/public/.vite/manifest.json');

    if (!file_exists($manifest_path)) return;

    $manifest = json_decode(file_get_contents($manifest_path), true);
    $main = $manifest['resources/scripts/app.js'];

    wp_enqueue_script(
        'theme-js',
        get_theme_file_uri('/public/' . $main['file']),
        [],
        null,
        true
    );

    wp_enqueue_style(
        'theme-css',
        get_theme_file_uri('/public/' . $main['css'][0]),
        [],
        null
    );
}
add_action('wp_enqueue_scripts', 'load_vite_assets');
add_action('enqueue_block_editor_assets', 'load_vite_assets');
