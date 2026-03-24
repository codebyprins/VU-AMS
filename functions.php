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

    add_theme_support('editor-styles');
}
add_action('wp_enqueue_scripts', 'vuams_enqueue_assets');

// Register blocks from block.json files
add_action('init', function () {
    register_block_type(__DIR__ . '/blocks/header-hero');
}, 9);

// Enqueue block editor script
add_action('enqueue_block_editor_assets', function() {
    wp_enqueue_script(
        'vuams-header-hero-block',
        get_template_directory_uri() . '/blocks/header-hero/index.js',
        array('wp-blocks', 'wp-block-editor', 'wp-element'),
        filemtime(get_template_directory() . '/blocks/header-hero/index.js')
    );
});

// Restrict editor to only custom blocks
function vuams_allowed_blocks( $allowed_blocks, $block_editor_context ) {
    return array(
        'vu-ams/header-hero',
    );
}
add_filter( 'allowed_block_types_all', 'vuams_allowed_blocks', 10, 2 );

// Lock custom blocks to prevent deletion
add_action('enqueue_block_editor_assets', function() {
    wp_enqueue_script(
        'vuams-block-locker',
        get_template_directory_uri() . '/js/block-editor.js',
        array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
        filemtime(get_template_directory() . '/js/block-editor.js')
    );
});