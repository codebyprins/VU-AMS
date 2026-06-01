<?php
add_filter('wpcf7_form_tag', function ($tag) {
    if (!is_array($tag) || ($tag['name'] ?? '') !== 'your-product') {
        return $tag;
    }

    $products = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $options = array_map(fn($p) => $p->post_title, $products);

    $tag['values'] = $options;
    $tag['labels'] = $options;

    return $tag;
});
