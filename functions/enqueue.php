<?php
function theme_enqueue_assets() {
    // Tailwind CSS
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/public/css/app.css',
        [],
        filemtime(get_template_directory() . '/public/css/app.css')
    );

    // JS
    wp_enqueue_script(
        'theme-app',
        get_template_directory_uri() . '/public/js/main.js',
        [],
        filemtime(get_template_directory() . '/public/js/main.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');