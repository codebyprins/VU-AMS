<?php
$publications_tags_filter = get_field('publications_tags_filter', 'option') ?: [];
$selected_year = sanitize_text_field($_GET['publication_year_filter'] ?? $_GET['year'] ?? '');
$selected_search = sanitize_text_field($_GET['search'] ?? '');
$selected_author = sanitize_text_field($_GET['author'] ?? '');
$selected_keywords = [];

if (!empty($_GET['keyword'])) {
    $selected_keywords = is_array($_GET['keyword'])
        ? array_map('sanitize_text_field', $_GET['keyword'])
        : [sanitize_text_field($_GET['keyword'])];
}

$filter_action_url = get_permalink(get_queried_object_id());

if (is_post_type_archive('publication')) {
    $filter_action_url = get_post_type_archive_link('publication');
}

if (!$filter_action_url) {
    $filter_action_url = home_url('/');
}

$paged = max(
    1,
    get_query_var('paged') ?: get_query_var('page') ?: 1
);

$tax_query = [
    'relation' => 'AND'
];

if (!empty($selected_year)) {
    $tax_query[] = [
        'taxonomy' => 'publication_year',
        'field'    => 'slug',
        'terms'    => [$selected_year],
    ];
}

if (!empty($selected_keywords)) {
    $tax_query[] = [
        'taxonomy' => 'publication_keyword',
        'field'    => 'slug',
        'terms'    => $selected_keywords,
        'operator' => 'IN',
    ];
}
$args = [
    'post_type'      => 'publication',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

if (!empty($selected_search)) {
    $args['s'] = $selected_search;
}

if (!empty($selected_author)) {
    $tax_query[] = [
        'taxonomy' => 'publication_author',
        'field'    => 'slug',
        'terms'    => [$selected_author],
    ];
}

if (count($tax_query) > 1) {
    $args['tax_query'] = $tax_query;
}

$query = new WP_Query($args);

$years = get_terms([
    'taxonomy'   => 'publication_year',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'DESC',
]);

if (is_wp_error($years)) {
    $years = [];
}

$keywords = get_terms([
    'taxonomy'   => 'publication_keyword',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

if (is_wp_error($keywords)) {
    $keywords = [];
}
?>

<section class="bg-white py-10">
    <div class="container mx-auto px-4 flex md:flex-row flex-col md:gap-16 gap-5 justify-between relative">
        <form
            method="GET"
            action="<?= esc_url($filter_action_url); ?>"
            class="xl:w-1/4 md:w-2/5 w-full md:sticky md:top-24 left-0 relative top-0 bg-[#d4eff2] border-4 border-[#01B4C9] rounded-xl px-4 py-5 self-start md:block">
            <h3 class="mb-6">Filters</h3>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Title or Content</p>
                <input
                    type="text"
                    name="search"
                    placeholder="Search publications..."
                    value="<?= esc_attr($selected_search); ?>"
                    class="w-full bg-white border border-black py-2 px-4">
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Publication year</p>
                <select
                    name="publication_year_filter"
                    class="w-full bg-white border border-black py-2 px-4">
                    <option value="">All Years</option>
                    <?php foreach ($years as $year) : ?>
                        <option
                            value="<?= esc_attr($year->slug); ?>"
                            <?= selected($selected_year, $year->slug); ?>>
                            <?= esc_html($year->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Author</p>
                <input
                    type="text"
                    name="author"
                    placeholder="Search author..."
                    value="<?= esc_attr($selected_author); ?>"
                    class="w-full bg-white border border-black py-2 px-4">
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Keyword</p>
                <select
                    name="keyword[]"
                    class="w-full bg-white border border-black py-2 px-4"
                    multiple>
                    <?php foreach ($publications_tags_filter as $filter) : ?>
                        <optgroup label="<?= esc_attr($filter['publications_tags_category']); ?>">
                            <?php foreach ($filter['publications_tags_tags'] as $tag_id) : ?>
                                <?php
                                $term = get_term($tag_id);
                                if (!$term || is_wp_error($term)) {
                                    continue;
                                }
                                ?>
                                <option
                                    value="<?= esc_attr($term->slug); ?>"
                                    <?php
                                    $is_selected = in_array($term->slug, $selected_keywords, true);
                                    echo $is_selected ? 'selected' : '';
                                    ?>>
                                    <?= esc_html($term->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex gap-4 items-center">
                <a
                    href="<?= esc_url($filter_action_url); ?>"
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
        <div class="xl:w-3/4 md:w-3/5 w-full">
            <div>
                <h3>Total publications: <?= $query->found_posts; ?></h3>
            </div>
            <div class="publications flex flex-col md:gap-8 gap-2">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <?php
                        $publication_id = get_the_ID();

                        $publication_tags = get_the_terms(
                            $publication_id,
                            'publication_keyword'
                        );

                        $authors = get_the_terms(
                            $publication_id,
                            'publication_author'
                        );

                        $years = get_the_terms(
                            $publication_id,
                            'publication_year'
                        );

                        $authors_str = '';

                        if ($authors && !is_wp_error($authors)) {

                            $authors_str = implode(
                                ', ',
                                wp_list_pluck($authors, 'name')
                            );
                        }

                        $year = '';

                        if ($years && !is_wp_error($years)) {
                            $year = $years[0]->name;
                        }
                        ?>

                        <div class="publication-item border-b-2 border-black p-6 overflow-hidden">
                            <?php if (!empty($publication_tags)) : ?>
                                <div class="tags flex flex-wrap gap-2 mb-4">
                                    <?php foreach ($publication_tags as $tag) : ?>
                                        <a
                                            href="?keyword=<?= esc_attr($tag->slug); ?>"
                                            class="tag bg-primary_light border border-black text-black px-3 py-1 rounded-full text-sm w-fit hover:bg-[#01B4C9] transition">

                                            <?= esc_html($tag->name); ?>

                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <a href="<?= esc_url(get_permalink($publication_id)); ?>" class="block hover:text-[#01B4C9] transition">
                                <h4 class="whitespace-nowrap text-ellipsis overflow-hidden">
                                    <?php the_title(); ?>
                                </h4>
                            </a>

                            <div class="publication-bottom flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <p><?= esc_html($authors_str); ?></p>
                                <p class="publication-date text-sm">
                                    <?= esc_html($year); ?>
                                </p>
                                <a href="<?= esc_url(get_permalink($publication_id)); ?>" class="btn btn-primary whitespace-nowrap">Read more</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="publication-item border-b-2 border-black p-6">
                        <p><?php esc_html_e('No publications found.', 'vu-ams'); ?></p>
                    </div>
                <?php endif; ?>
                <?php custom_pagination($query); ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>