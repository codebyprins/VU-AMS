<?php
function setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_image_size('content-block-image', 550, 580, true);

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    add_theme_support('menus');

    register_nav_menus([
        'main_menu'   => __('Main Menu', 'vu-ams'),
    ]);
}


add_action('after_setup_theme', 'setup');