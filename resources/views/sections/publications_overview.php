<?php

?>

<section class="bg-white py-10">
    <div class="container mx-auto px-4 flex md:flex-row flex-col md:gap-16 gap-5 justify-between">
        <div class="xl:w-1/4 md:w-2/5 w-full bg-[#d4eff2] border-4 border-[#01B4C9] rounded-xl px-4 py-5 self-start md:block">
            <h3 class="mb-6">Filters</h3>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Filter optie 1</p>
                <select name="filter1" id="filter1" class="w-full bg-white border border-black py-2 px-4">
                    <option value="">Filter optie 1</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                </select>
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Filter optie 2</p>
                <select name="filter2" id="filter2" class="w-full bg-white border border-black py-2 px-4">
                    <option value="">Filter optie 2</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                </select>
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Filter optie 3</p>
                <select name="filter3" id="filter3" class="w-full bg-white border border-black py-2 px-4">
                    <option value="">Filter optie 3</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                </select>
            </div>

            <div class="filter-item flex flex-col gap-1 mb-0">
                <p>Filter optie 4</p>
                <select name="filter4" id="filter4" class="w-full bg-white border border-black py-2 px-4">
                    <option value="">Filter optie 4</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                </select>
            </div>

        </div>
        <div class="xl:w-3/4 md:w-3/5 w-full">
            <div class="publications flex flex-col md:gap-8 gap-2">
                <?php
                $paged = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);
                $publication_query = new WP_Query([
                    'post_type' => 'publication',
                    'post_status' => 'publish',
                    'posts_per_page' => 4,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ]);

                if ($publication_query->have_posts()) :
                    while ($publication_query->have_posts()) : $publication_query->the_post();
                        $publication_id = get_the_ID();
                        $publication_title = get_the_title();
                        $publication_link = get_permalink();
                        $publication_date = get_the_date('F j, Y');
                        $authors = get_field('authors', $publication_id);
                        $publication_tags = get_the_terms($publication_id, 'publication_tag');
                ?>
                        <div class="publication-item border-b-2 border-black p-6 overflow-hidden">
                            <?php if (!empty($publication_tags) && !is_wp_error($publication_tags)) : ?>
                                <div class="tags flex flex-wrap gap-2 mb-4">
                                    <?php foreach ($publication_tags as $tag) : ?>
                                        <div class="tag bg-[#F6DD75] border border-black text-black px-3 py-1 rounded-full text-sm w-fit"><?php echo esc_html($tag->name); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <h4 class="whitespace-nowrap text-ellipsis overflow-hidden"><?php echo the_title(); ?></h4>
                            <div class="publication-bottom flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <p><?php echo esc_html($authors); ?></p>
                                <div class="flex gap-5 items-center">
                                    <p class="publication-date text-sm"><?php echo esc_html($publication_date); ?></p>
                                    <a href="<?php echo esc_url($publication_link); ?>" class="btn btn-primary hover:underline">Read more</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="publication-item border border-[#01B4C9] rounded-xl p-6">
                        <p><?php esc_html_e('No publications found.', 'vu-ams'); ?></p>
                    </div>
                <?php endif; ?>
                <?php custom_pagination($publication_query); ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>