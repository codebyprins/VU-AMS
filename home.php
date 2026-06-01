<?php get_header(); ?>

<?php
$page_id = get_option('page_for_posts');

if (have_rows('flexible_blocks', $page_id)):

  while (have_rows('flexible_blocks', $page_id)):
    the_row();

    $layout = get_row_layout();
    $file = "resources/views/sections/{$layout}.php";

    if (locate_template($file)) {
      get_template_part(
        "resources/views/sections/{$layout}",
        null,
        ['page_id' => $page_id]
      );
    } else {
      echo "<strong>MISSING TEMPLATE:</strong> {$file}";
    }

  endwhile;

endif;
?>

<?php get_footer(); ?>