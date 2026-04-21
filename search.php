<?php get_header(); ?>

<section class="min-h-[calc(100vh-600px)]">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold mb-2">
            Search results for: <?php echo esc_html(get_search_query()); ?>
        </h1>

        <?php if (have_posts()) : ?>
            <div class="flex flex-col">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="bg-white border-b border-black">
                        <div class="p-6 flex flex-row justify-between w-full">
                            <div class="left w-full">
                                <div class="flex flex-col gap-3 mb-3">
                                    <div class="flex gap-2 items-center">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" stroke="#01B4C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="13 2 13 9 20 9" stroke="#01B4C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <span>
                                            <?php
                                            $post_type = get_post_type();
                                            $post_type_obj = get_post_type_object($post_type);
                                            echo $post_type_obj ? $post_type_obj->labels->singular_name : ucfirst($post_type);
                                            ?>
                                        </span>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="text-xl text-[#01B4C9] max-w-[600px] overflow-hidden text-ellipsis whitespace-nowrap hover:text-[#F7C80C] transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                                <p class="text-gray-700 line-clamp-2 max-w-[600px]">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </div>
                            <div class="right md:flex hidden items-center justify-center">
                                <a href="<?php the_permalink(); ?>" class="bg-[#01B4C9] hover:bg-[#F7C80C] transition-colors rounded-full w-[50px] h-[50px] flex items-center justify-center">
                                    <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M25.375 14.4997L19.3333 8.45801M25.375 14.4997L19.3333 20.5413M25.375 14.4997H3.625" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php custom_pagination($wp_query); ?>
        <?php else : ?>
            <div class="bg-gray-100 rounded-lg p-12 text-center mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">No results found</h2>
                <p class="text-gray-600 mb-6">
                    Sorry, no posts found for "<strong><?php echo esc_html(get_search_query()); ?></strong>".
                    Try searching with different keywords.
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-[#F8F8F8] py-10">
    <div class="container mx-auto px-4 text-center flex flex-col gap-3 md:gap-5 items-center">
        <h2 class="text-2xl md:text-4xl font-bold">Interested in VU-AMS?</h2>
        <div class="max-w-[600px]">Want to learn more or see how VU-AMS can support your research? Get in touch with us.</div>
        <a class="btn btn-primary w-fit" href="/contact" target="_blank">Contact us</a>
    </div>
</section>

<?php get_footer(); ?>