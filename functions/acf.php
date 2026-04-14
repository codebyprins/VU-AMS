<?php

// Register ACF Options Page (Global Settings)
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Global Settings',
            'menu_title' => 'Global Settings',
            'menu_slug'  => 'global-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        ]);
    }
});