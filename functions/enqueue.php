<?php
function vu_ams_enqueue_styles()
{
  // Enqueue Tailwind
  wp_enqueue_style(
    'vu-ams-tailwind',
    get_stylesheet_directory_uri() . '/resources/styles/app.css',
    [],
    '1.0'
  );

  //enqueue rest
}
add_action('wp_enqueue_scripts', 'vu_ams_enqueue_styles');
