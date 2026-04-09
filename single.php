<?php get_header(); ?>

<?php if (have_rows('flexible_blocks')): ?>
    <?php while (have_rows('flexible_blocks')): the_row(); ?>

        <?php
        $layout = get_row_layout();

        if ($layout == 'voorbeeld_1') :
          get_template_part('assets/blocks/voorbeeld_1');

        elseif ($layout == 'voorbeeld_2') :
          get_template_part('assets/blocks/voorbeeld_2');

        endif;
        ?>

    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>