<?php

add_action(
    'VU_after_insert_publication',
    'provide_publication_with_extra_data',
    10,
    1
);

function provide_publication_with_extra_data($post_id)
{
    if (get_post_type($post_id) !== 'publication') {
        return;
    }

    $source_url = get_field('google_scholar_url', $post_id);

    if (!$source_url) {
        return;
    }

    $html = get_html_from_url($source_url);

    if (!$html) {
        return;
    }

    $publication_data = parse_google_scholar_page($html);

    if (empty($publication_data)) {
        return;
    }

    update_publication_data($post_id, $publication_data);
}

function parse_google_scholar_page($html)
{
    $data = [
        'meta_description' => '',
        'authors' => '',
        'publication_date' => '',
        'description' => '',
    ];

    $dom = new DOMDocument();

    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    $meta = $xpath
        ->query('//meta[@name="description"]/@content')
        ->item(0);

    if ($meta) {
        $data['meta_description'] = trim($meta->nodeValue);
    }

    $nodes = $xpath->query('//div[@id="gs_bdy_ccl"]//div[contains(@class,"gs_scl")]');

    foreach ($nodes as $index => $node) {

        $value = trim($node->textContent);

        if (!$value) {
            continue;
        }

        if ($index === 0) {
            $data['authors'] = $value;
        }

        if ($index === 1) {
            $data['publication_date'] = $value;
        }

        if ($index === 2) {
            $data['description'] = $value;
        }
    }

    return $data;
}

function update_publication_data($post_id, $data)
{
    $post = get_post($post_id);

    if (!$post) {
        return;
    }

    $content = trim($data['description']);

    if (
        $content &&
        $content !== trim($post->post_content)
    ) {

        $_POST['yoast_wpseo_metadesc']
            = $data['meta_description'];

        wp_update_post([
            'ID' => $post_id,
            'post_content' => $content,
        ]);
    }

    if (
        !empty($data['authors']) &&
        $data['authors'] !== get_field('authors', $post_id)
    ) {

        update_field(
            'field_625e8cfed4f38',
            $data['authors'],
            $post_id
        );
    }

    if (
        !empty($data['publication_date']) &&
        $data['publication_date']
        !== get_field('publication_date', $post_id)
    ) {

        update_field(
            'field_625e8fbcd4f39',
            $data['publication_date'],
            $post_id
        );
    }
}

function get_html_from_url($url)
{
    $response = wp_remote_get($url, [
        'timeout' => 10,
        'sslverify' => false,
        'user-agent' =>
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
    ]);

    if (is_wp_error($response)) {
        return false;
    }

    return wp_remote_retrieve_body($response);
}