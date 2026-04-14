<?php if (have_rows('flexible_blocks')): ?>
  <?php while (have_rows('flexible_blocks')): the_row(); ?>

    <?php
    $layout = get_row_layout();
// Zorg ervoor dat de bestandnaam overeenkomt met de layout naam in ACF, bijv. 'vb_section' voor 'vb-section.php'
    $file = "resources/views/sections/{$layout}.php";

    if (locate_template($file)) {
        get_template_part("resources/views/sections/{$layout}");
    } else {
        echo "<strong>MISSING TEMPLATE:</strong> {$file}";
    }

        elseif ($layout == 'slider') :
            get_template_part('resources/views/sections/slider');

        elseif ($layout == 'map') :
            get_template_part('resources/views/sections/map');

        elseif ($layout == 'testimonials') :
            get_template_part('resources/views/sections/testimonials');

        elseif ($layout == 'faq') :
            get_template_part('resources/views/sections/faq');

        elseif ($layout == 'cta') :
            get_template_part('resources/views/sections/cta');

        elseif ($layout == 'stats') :
            get_template_part('resources/views/sections/stats');

        elseif ($layout == 'text_block') :
            get_template_part('resources/views/sections/text_block');

        elseif ($layout == 'history') :
            get_template_part('resources/views/sections/history');

        elseif ($layout == 'text_button') :
            get_template_part('resources/views/sections/text_button');

        elseif ($layout == 'page_cards') :
            get_template_part('resources/views/sections/page_cards');

        elseif ($layout == 'product_cards') :
            get_template_part('resources/views/sections/product_cards');

        elseif ($layout == 'productUSBS') :
            get_template_part('resources/views/sections/productUSBS');

        endif;
        ?>

    <?php endwhile; ?>
<?php endif; ?>