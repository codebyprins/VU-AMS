<?php 
get_header();

$selected_search = sanitize_text_field($_GET['s'] ?? '');
$selected_cpt = sanitize_text_field($_GET['cpt'] ?? '');
$filter_action_url = home_url('/');
$filter_reset_url = home_url('/?s=' . urlencode($selected_search));

$post_types = get_post_types(['public' => true, '_builtin' => false], 'objects');
$available_cpts = [];
foreach ($post_types as $post_type) {
    if (in_array($post_type->name, ['mailpoet_page', 'team-member', 'location'], true)) {
        continue;
    }
    $available_cpts[$post_type->name] = $post_type->labels->singular_name;
}

$search_query = $selected_search ?: get_search_query();

$paged = max(1, get_query_var('paged') ?: 1);
$args = [
    'post_type' => !empty($selected_cpt) ? [$selected_cpt] : array_keys($available_cpts),
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
];

if (!empty($search_query)) {
    $args['s'] = $search_query;
}

$mailpoint = get_page_by_path('mailpoint');
$exclude_ids = [];
if ($mailpoint) {
    $exclude_ids[] = $mailpoint->ID;
}

$excluded_post_types = ['mailpoet_page', 'team-member', 'location'];
foreach ($excluded_post_types as $post_type) {
    $excluded_posts = get_posts([
        'post_type' => $post_type,
        'numberposts' => -1,
        'fields' => 'ids',
    ]);
    if ($excluded_posts) {
        $exclude_ids = array_merge($exclude_ids, $excluded_posts);
    }
}

if (!empty($exclude_ids)) {
    $args['post__not_in'] = $exclude_ids;
}

$search_results = new WP_Query($args);
?>

<section class="min-h-[calc(100vh-600px)]">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold mb-5">
            Search results for: <?php echo esc_html($search_query); ?>
        </h1>

        <?php if ($search_results->have_posts()) : ?>
            <div class="flex md:flex-row flex-col md:gap-16 gap-5 justify-between">
                <form
                    method="GET"
                    action="<?= esc_url($filter_action_url); ?>"
                    class="xl:w-1/4 md:w-2/5 w-full md:sticky md:top-24 left-0 relative top-0 bg-[#d4eff2] border-4 border-[#01B4C9] rounded-xl px-4 py-5 self-start md:block">
                    <h3 class="mb-6">Filters</h3>

                    <div class="filter-item flex flex-col gap-1 mb-5">
                        <p>Title or Content</p>
                        <input
                            type="text"
                            name="s"
                            placeholder="Search publications..."
                            value="<?= esc_attr($selected_search); ?>"
                            class="w-full bg-white border border-black py-2 px-4">
                    </div>

                    <div class="filter-item flex flex-col gap-1 mb-5">
                        <p>Content Type</p>
                        <select name="cpt" class="w-full bg-white border border-black py-2 px-4">
                            <option value="">All Types</option>
                            <?php foreach ($available_cpts as $cpt_slug => $cpt_label) : ?>
                                <option 
                                    value="<?= esc_attr($cpt_slug); ?>"
                                    <?= selected($selected_cpt, $cpt_slug); ?>>
                                    <?= esc_html($cpt_label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex gap-4 items-center">
                        <a
                            href="<?= esc_url($filter_reset_url); ?>"
                            class="btn btn-primary-outline flex-1 flex justify-center">
                            <?php
                            echo theme_svg('rotate-left', 'w-4 h-full');
                            ?>
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary flex-1 flex justify-center">
                            <?php
                            echo theme_svg('magnifying-glass', 'w-4 h-full');
                            ?>
                        </button>
                    </div>
                </form>
                <div class="flex flex-col xl:w-3/4 md:w-3/5 w-full">
                    <?php while ($search_results->have_posts()) : $search_results->the_post(); ?>
                        <article class="bg-white border-b border-black">
                            <div class="p-6 flex flex-row justify-between w-full">
                                <div class="left w-full">
                                    <div class="flex flex-col gap-3 mb-3">
                                        <div class="flex gap-2 items-center">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" stroke="#01B4C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <polyline points="13 2 13 9 20 9" stroke="#01B4C9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>
                                                <?php
                                                $post_type = get_post_type();
                                                $post_type_obj = get_post_type_object($post_type);
                                                echo $post_type_obj ? $post_type_obj->labels->singular_name : ucfirst($post_type);
                                                ?>
                                            </span>
                                        </div>
                                        <a href="<?php
                                                    if (get_post_type() === 'faq') {
                                                        echo esc_url(get_permalink(get_page_by_path('support')) . '#faq');
                                                    } elseif (get_post_type() === 'team-member') {
                                                        echo esc_url(get_permalink(get_page_by_path('about-us')));
                                                    } else {
                                                        the_permalink();
                                                    }
                                                    ?>" class="text-xl text-[#01B4C9] max-w-3xloverflow-hidden text-ellipsis whitespace-nowrap hover:text-[#F7C80C] transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </div>
                                    <p class="text-gray-700 line-clamp-2 max-w-3xl">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                    </p>
                                </div>
                                <div class="right md:flex hidden items-center justify-center">
                                    <a href="<?php
                                                if (get_post_type() === 'faq') {
                                                    echo esc_url(get_permalink(get_page_by_path('support')) . '#faq');
                                                } elseif (get_post_type() === 'team-member') {
                                                    echo esc_url(get_permalink(get_page_by_path('about-us')));
                                                } else {
                                                    the_permalink();
                                                }
                                                ?>" class="bg-[#01B4C9] hover:bg-[#F7C80C] transition-colors rounded-full w-[50px] h-[50px] flex items-center justify-center">
                                        <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M25.375 14.4997L19.3333 8.45801M25.375 14.4997L19.3333 20.5413M25.375 14.4997H3.625" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                    <?php custom_pagination($search_results); ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="bg-gray-100 rounded-lg p-12 text-center mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">No results found</h2>
                <p class="text-gray-600 mb-6">
                    Sorry, no posts found for "<strong><?php echo esc_html($search_query); ?></strong>".
                    Try searching with different keywords.
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-[#F8F8F8] py-10">
    <div class="container mx-auto px-4 text-center flex flex-col gap-3 md:gap-5 items-center">
        <h2 class="text-2xl md:text-4xl font-bold">Interested in VU-AMS?</h2>
        <div class="max-w-3xl">Want to learn more or see how VU-AMS can support your research? Get in touch with us.</div>
        <a class="btn btn-primary w-fit" href="/contact" target="_blank">Contact us</a>
    </div>
</section>

<?php get_footer(); ?>