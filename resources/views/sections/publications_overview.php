<?php

?>

<section class="bg-white py-10">
    <div class="container mx-auto px-4 flex md:flex-row flex-col gap-10">
        <div class="xl:w-1/5 md:w-2/5 w-full bg-[#ABE0E6] border-2 border-[#01B4C9] rounded-xl p-6 self-start md:block">
            <h3>Filters</h3>

        </div>
        <div class="xl:w-4/5 md:w-3/5 w-full">
            <div class="publications flex flex-col gap-8">
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
                        <div class="publication-item border border-[#01B4C9] rounded-xl p-6 overflow-hidden">
                            <?php if (!empty($publication_tags) && !is_wp_error($publication_tags)) : ?>
                                <div class="tags flex flex-wrap gap-2 mb-4">
                                    <?php foreach ($publication_tags as $tag) : ?>
                                        <div class="tag bg-[#F7C80C] border border-black text-black px-3 py-1 rounded-full text-sm w-fit"><?php echo esc_html($tag->name); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <h2 class="whitespace-nowrap text-ellipsis overflow-hidden"><?php echo the_title(); ?></h2>
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