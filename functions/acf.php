<?php

// here go the acf settings, field groups, etc.

//remove standard editor from posts and pages, use acf for input
function remove_editor_globally()
{
  remove_post_type_support('post', 'editor');
  remove_post_type_support('page', 'editor');
}
add_action('init', 'remove_editor_globally');
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
