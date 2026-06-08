<?php
$selected_search   = sanitize_text_field($_GET['search'] ?? '');
$selected_tag      = sanitize_text_field($_GET['tag'] ?? '');
$selected_order    = in_array($_GET['order'] ?? '', ['ASC', 'DESC'], true) ? $_GET['order'] : 'DESC';

$filter_action_url = get_permalink(get_queried_object_id()) ?: home_url('/');

$paged = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);

$tax_query = ['relation' => 'AND'];

if (!empty($selected_tag)) {
    $tax_query[] = [
        'taxonomy' => 'support-blog-tag',
        'field'    => 'slug',
        'terms'    => [$selected_tag],
    ];
}

$args = [
    'post_type'      => 'support-blog',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => $selected_order,
];

if (!empty($selected_search)) {
    $args['s'] = $selected_search;
}

if (count($tax_query) > 1) {
    $args['tax_query'] = $tax_query;
}

$blog_query = new WP_Query($args);

$blog_tags = get_terms([
    'taxonomy'   => 'support-blog-tag',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);
if (is_wp_error($blog_tags)) {
    $blog_tags = [];
}

?>

<section class="bg-white py-10">
    <div class="container mx-auto px-4 flex md:flex-row flex-col md:gap-16 gap-5 justify-between">
        <form
            method="GET"
            action="<?= esc_url($filter_action_url); ?>"
            class="xl:w-1/4 md:w-2/5 w-full bg-[#d4eff2] border-4 border-[#01B4C9] rounded-xl px-4 py-5 self-start md:block">
            <h3 class="mb-6">Filters</h3>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Zoeken</p>
                <input
                    type="text"
                    name="search"
                    placeholder="Zoek in blogs..."
                    value="<?= esc_attr($selected_search); ?>"
                    class="w-full bg-white border border-black py-2 px-4">
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Support blog tag</p>
                <select name="tag" class="w-full bg-white border border-black py-2 px-4">
                    <option value="">Alle tags</option>
                    <?php foreach ($blog_tags as $tag) : ?>
                        <option
                            value="<?= esc_attr($tag->slug); ?>"
                            <?= selected($selected_tag, $tag->slug); ?>>
                            <?= esc_html($tag->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Sortering op datum</p>
                <select name="order" class="w-full bg-white border border-black py-2 px-4">
                    <option value="DESC" <?= selected($selected_order, 'DESC'); ?>>Nieuwste eerst</option>
                    <option value="ASC" <?= selected($selected_order, 'ASC'); ?>>Oudste eerst</option>
                </select>
            </div>

            <div class="flex gap-4 items-center">
                <a
                    href="<?= esc_url($filter_action_url); ?>"
                    class="btn btn-primary-outline flex-1 flex justify-center">
                    <?php echo theme_svg('rotate-left', 'w-4 h-full'); ?>
                </a>
                <button type="submit" class="btn btn-primary flex-1 flex justify-center">
                    <?php echo theme_svg('magnifying-glass', 'w-4 h-full'); ?>
                </button>
            </div>
        </form>

        <div class="xl:w-3/4 md:w-3/5 w-full">
            <div class="mb-4">
                <h3>Totaal: <?= $blog_query->found_posts; ?></h3>
            </div>
            <div class="publications flex flex-col md:gap-8 gap-2">
                <?php if ($blog_query->have_posts()) : ?>
                    <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                        <?php
                        $post_id   = get_the_ID();
                        $post_link = get_permalink();
                        $post_date = get_the_date('F j, Y');
                        $authors   = get_field('authors', $post_id);
                        $post_tags = get_the_terms($post_id, 'support-blog-tag');
                        ?>
                        <div class="publication-item border-b-2 border-black p-6 overflow-hidden">
                            <?php if (!empty($post_tags) && !is_wp_error($post_tags)) : ?>
                                <div class="tags flex flex-wrap gap-2 mb-4">
                                    <?php foreach ($post_tags as $pt) : ?>
                                        <a
                                            href="?tag=<?= esc_attr($pt->slug); ?>"
                                            class="tag bg-[#00b6cb] border border-black text-white px-3 py-1 rounded-full text-sm w-fit hover:bg-[#018898] transition">
                                            <?= esc_html($pt->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <a href="<?= esc_url($post_link); ?>" class="block hover:text-[#01B4C9] transition">
                                <h4 class="whitespace-nowrap text-ellipsis overflow-hidden">
                                    <?php the_title(); ?>
                                </h4>
                            </a>
                            <div class="publication-bottom flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <p><?= esc_html($authors); ?></p>
                                <div class="flex gap-5 items-center">
                                    <p class="publication-date text-sm"><?= esc_html($post_date); ?></p>
                                    <a href="<?= esc_url($post_link); ?>" class="btn btn-primary hover:underline">Read more</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="publication-item border-b-2 border-black p-6">
                        <p><?php esc_html_e('Geen blogs gevonden.', 'vu-ams'); ?></p>
                    </div>
                <?php endif; ?>
                <?php custom_pagination($blog_query); ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>