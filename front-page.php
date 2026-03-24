<?php get_header();
?>
<!-- wp:group {"templateLock":"all"} -->

<div class="wp-block-group">
    Content for the front page goes here. You can edit this file at <code>front-page.php</code> in your theme. You can also create custom blocks and add them here using the block editor.
    <!-- Your blocks go here -->
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>
<!-- /wp:group -->
<?php
get_footer(); ?>