<?php if (have_rows('flexible_blocks')): ?>
  <?php while (have_rows('flexible_blocks')): the_row(); ?>

        <?php
        $layout = get_row_layout();
        $file = "resources/views/sections/{$layout}.php";
    if (locate_template($file)) {
        get_template_part("resources/views/sections/{$layout}");
    } else {
        echo "<strong>MISSING TEMPLATE:</strong> {$file}";
    }?>

    <?php endwhile; ?>
<?php endif; ?>
