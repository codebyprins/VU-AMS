<?php

//here go acf settings, field groups, etc.
function remove_editor_from_acf_cpt()
{
  remove_post_type_support('product', 'editor');
}
add_action('init', 'remove_editor_from_acf_cpt');
