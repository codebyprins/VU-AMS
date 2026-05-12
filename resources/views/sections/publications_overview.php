<?php

$paged = max(
    1,
    get_query_var('paged') ?: get_query_var('page') ?: 1
);

$tax_query = [
    'relation' => 'AND'
];

// filter by year

if (!empty($_GET['year'])) {

    $tax_query[] = [
        'taxonomy' => 'publication_year',
        'field'    => 'slug',
        'terms'    => sanitize_text_field($_GET['year']),
    ];
}


if (!empty($_GET['keyword'])) {

    $tax_query[] = [
        'taxonomy' => 'publication_keyword',
        'field'    => 'slug',
        'terms'    => sanitize_text_field($_GET['keyword']),
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

// search by title/content/keywords

if (!empty($_GET['search'])) {

    $args['s'] = sanitize_text_field($_GET['search']);
}

// search by author
if (!empty($_GET['author'])) {

    $author_search = sanitize_text_field($_GET['author']);
    $args['meta_query'] = [
        [
            'key'     => 'publication_author',
            'value'   => $author_search,
            'compare' => 'LIKE',
        ]
    ];
}

if (count($tax_query) > 1) {
    $args['tax_query'] = $tax_query;
}

$query = new WP_Query($args);

// the filter opions
$years = get_terms([
    'taxonomy'   => 'publication_year',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'DESC',
]);

$keywords = get_terms([
    'taxonomy'   => 'publication_keyword',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

$publication_query = new WP_Query([
    'post_type' => 'publication',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<section class="bg-white py-10">
    <div class="container mx-auto px-4 flex md:flex-row flex-col md:gap-16 gap-5 justify-between">
        <form
            method="GET"
            class="xl:w-1/4 md:w-2/5 w-full bg-[#d4eff2] border-4 border-[#01B4C9] rounded-xl px-4 py-5 self-start md:block">
            <h3 class="mb-6">Filters</h3>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Year</p>
                <select
                    name="year"
                    class="w-full bg-white border border-black py-2 px-4">
                    <option value="">All Years</option>
                    <?php foreach ($years as $year) : ?>
                        <option
                            value="<?= esc_attr($year->slug); ?>"
                            <?= selected($_GET['year'] ?? '', $year->slug); ?>>
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
                    value="<?= esc_attr($_GET['author'] ?? ''); ?>"
                    class="w-full bg-white border border-black py-2 px-4">
            </div>

            <div class="filter-item flex flex-col gap-1 mb-5">
                <p>Title/Keywords/Content</p>
                <input
                    type="text"
                    name="search"
                    placeholder="Search publications..."
                    value="<?= esc_attr($_GET['search'] ?? ''); ?>"
                    class="w-full bg-white border border-black py-2 px-4">
            </div>
            <button
                type="submit"
                class="btn btn-primary mt-6 w-full">
                Apply Filters
            </button>
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
                                        <div class="tag bg-[#F6DD75] border border-black text-black px-3 py-1 rounded-full text-sm w-fit">
                                            <?= esc_html($tag->name); ?>
                                        </div>
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
                    <div class="publication-item border border-[#01B4C9] rounded-xl p-6">
                        <p>
                            No publications found using given criteria
                        </p>
                    </div>
                <?php endif; ?>
                <?php custom_pagination($publication_query); ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>