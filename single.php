<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php get_header(); ?>

<?php
// Override the field name for posts
if (have_rows('post_blocks')):
    while (have_rows('post_blocks')): the_row();
        $layout = get_row_layout();
        $file = "resources/views/sections/{$layout}.php";
        if (locate_template($file)) {
            get_template_part("resources/views/sections/{$layout}");
        } else {
            echo "<strong>MISSING TEMPLATE:</strong> {$file}";
        }
    endwhile;
endif;
?>

<?php get_footer(); ?>