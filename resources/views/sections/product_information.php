<section class="section py-8 w-100 p-2">

<?php if (have_rows('product_items')): ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">

        <?php while (have_rows('product_items')): the_row();

            $title = get_sub_field('title');
            $content = get_sub_field('content');

            if (empty($title) && empty($content)) {
                continue;
            }
        ?>

            <div class="accordion-item border-2 border-yellow-400 rounded-lg overflow-hidden cursor-pointer transition-colors duration-300 bg-white">

                <?php if ($title): ?>
                    <div class="accordion-header bg-[#F3F3F3] px-[18px] py-3 flex justify-between items-center hover:bg-[#d6d6d6] transition-colors duration-300">
                        <h3 class="text-gray-700 text-[15px]">
                            <?php echo esc_html($title); ?>
                        </h3>
                        <span class="icon font-bold text-lg text-[#01B4C9]">+</span>
                    </div>
                <?php endif; ?>

                <?php if ($content): ?>
                    <div class="panel bg-white max-h-0 overflow-hidden transition-[max-height] duration-300 ease-out">
                        <p class="pt-4 px-[18px] pb-[18px]">
                            <?php echo get_sub_field('content', false, false); ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>

        <?php endwhile; ?>

    </div>

<?php endif; ?>

</section>