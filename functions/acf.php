<?php

// here go the acf settings, field groups, etc.

//remove standard editor from posts and pages, use acf for input
function remove_editor_globally()
{
  remove_post_type_support('post', 'editor');
  remove_post_type_support('page', 'editor');
}
add_action('init', 'remove_editor_globally');
