<?php
// register the post type and taxaonmies
add_action('init', function () {

  register_post_type('publication', [
    'label' => 'Publications',
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'publications'],
    'menu_icon' => 'dashicons-book',
    'supports' => ['title', 'editor', 'excerpt'],
    'show_in_rest' => true,
  ]);

  $taxonomies = [
    'publication_year'   => 'Year',
    'publication_author' => 'Author',
    'publication_keyword' => 'Keyword',
    'publication_source' => 'Source',
  ];

  foreach ($taxonomies as $slug => $label) {
    register_taxonomy($slug, 'publication', [
      'label' => $label,
      'public' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'hierarchical' => false,
    ]);
  }
});

//run the sync functions

function run_publication_sync()
{
  set_time_limit(120);

  $zotero_count  = sync_zotero_publications();

  publication_sync_log([
    'last_run_start'  => current_time('mysql'),
    'last_run_end'    => current_time('mysql'),
    'zotero_updated'  => $zotero_count,
    // 'scholar_updated' => $scholar_count,
    'total_updated'   => $zotero_count, // + $scholar_count,
    'total_posts'     => wp_count_posts('publication')->publish,
  ]);
}

// log sync info in options and update posts
function upsert_publication($data)
{
  if (empty($data['external_id'])) {
    return false;
  }

  $existing = get_posts([
    'post_type'   => 'publication',
    'fields'      => 'ids',
    'numberposts' => 1,
    'meta_key'    => 'external_id',
    'meta_value'  => $data['external_id'],
  ]);

  $post_id = $existing[0] ?? 0;

  $post_args = [
    'post_type'    => 'publication',
    'post_status'  => 'publish',
    'post_title'   => $data['title'] ?? '',
    'post_content' => $data['content'] ?? '',
    'post_excerpt' => $data['excerpt'] ?? '',
  ];

  if ($post_id) {
    $post_args['ID'] = $post_id;
    wp_update_post($post_args);
  } else {
    $post_id = wp_insert_post($post_args);
  }

  if (!$post_id || is_wp_error($post_id)) {
    return false;
  }


  update_post_meta($post_id, 'external_id', $data['external_id']);

  // YEAR
  if (!empty($data['year'])) {
    wp_set_object_terms(
      $post_id,
      [$data['year']],
      'publication_year'
    );
  }

  // AUTHORS
  if (!empty($data['authors'])) {
    wp_set_object_terms(
      $post_id,
      $data['authors'],
      'publication_author'
    );
  }

  // KEYWORDS
  if (!empty($data['keywords'])) {
    wp_set_object_terms(
      $post_id,
      $data['keywords'],
      'publication_keyword'
    );
  }

  // SOURCE
  if (!empty($data['source'])) {
    wp_set_object_terms(
      $post_id,
      [$data['source']],
      'publication_source'
    );
  }

  if (!empty($data['url'])) {
    update_post_meta($post_id, 'publication_url', esc_url_raw($data['url']));
  }

  if (!empty($data['doi'])) {
    update_post_meta($post_id, 'doi', $data['doi']);
  }

  if (!empty($data['publication_title'])) {
    update_post_meta(
      $post_id,
      'publication_title',
      sanitize_text_field($data['publication_title'])
    );
  }

  return $post_id;
}

// sync Zotera and safe as post
function sync_zotero_publications()
{
  $updated = 0;

  $group_id = get_field('zotero_group_id', 'option');
  if (!$group_id) return 0;

  $start = 0;
  $limit = 100;

  while (true) {

    $url = "https://api.zotero.org/groups/{$group_id}/items?format=json&limit={$limit}&start={$start}";
    $response = wp_remote_get($url, [
      'timeout' => 20,
    ]);

    if (is_wp_error($response)) break;

    $items = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($items)) break;

    foreach ($items as $item) {

      $data = $item['data'] ?? [];
      if (!$data || in_array($data['itemType'], ['note', 'attachment'])) continue;

      $post_id = upsert_publication([
        'external_id' => 'zotero_' . $item['key'],
        'title'       => $data['title'] ?? '',
        'content'     => $data['abstractNote'] ?? '',
        'excerpt'     => wp_trim_words($data['abstractNote'] ?? '', 30),

        'year' => !empty($data['date'])
          ? date('Y', strtotime($data['date']))
          : '',

        'authors' => array_map(function ($creator) {
          return trim(
            ($creator['firstName'] ?? '') . ' ' .
              ($creator['lastName'] ?? '')
          );
        }, $data['creators'] ?? []),

        'keywords' => !empty($data['tags'])
          ? array_column($data['tags'], 'tag')
          : [],

        'source' => 'Zotero',
        'url' => get_publication_url($data),

        'doi' => $data['DOI'] ?? '',

        'publication_title' => $data['publicationTitle']
          ?? $data['proceedingsTitle']
          ?? $data['bookTitle']
          ?? '',
      ]);

      if ($post_id) $updated++;
    }

    if (count($items) < $limit) break;
    $start += $limit;
  }

  return $updated;
}


// fetch data from google scholar using serpapi and safe as post
// function sync_google_scholar_publications()
// {
//   $updated = 0;

//   $api_key   = get_field('serpapi_api_key', 'option');
//   $author_id = get_field('google_scholar_author_id', 'option');

//   if (!$api_key || !$author_id) return 0;

//   $start = 0;
//   $limit = 20;
//   $pages = 0;

//   do {

//     $url = add_query_arg([
//       'engine'    => 'google_scholar_author',
//       'author_id' => $author_id,
//       'api_key'   => $api_key,
//       'start'     => $start,
//     ], 'https://serpapi.com/search.json');

//     $response = wp_remote_get($url);
//     if (is_wp_error($response)) break;

//     $body = json_decode(wp_remote_retrieve_body($response), true);
//     $articles = $body['articles'] ?? [];

//     foreach ($articles as $a) {

//       if (empty($a['title'])) continue;

//       $post_id = upsert_publication([
//         'external_id' => 'scholar_' . md5($a['title'] . ($a['link'] ?? '')),
//         'title'       => $a['title'],
//       ]);

//       if ($post_id) $updated++;
//     }

//     $start += $limit;
//     $pages++;

//     if ($pages >= 10) break;
//   } while (count($articles) === $limit);

//   return $updated;
// }

function get_publication_url($data)
{
  if (!empty($data['DOI'])) {
    return 'https://doi.org/' . ltrim($data['DOI'], '/');
  }

  return $data['url'] ?? '';
}

// DAILY CRON SYNC
add_action('init', function () {

  // avoid duplicate cron jobs
  if (!wp_next_scheduled('publications_daily_sync')) {

    wp_schedule_event(
      time(),
      'daily',
      'publications_daily_sync'
    );
  }
});

// actual cron callback
add_action('publications_daily_sync', function () {

  // lock to prevent overlapping syncs
  if (get_transient('publication_sync_running')) {
    return;
  }

  set_transient('publication_sync_running', true, 15 * MINUTE_IN_SECONDS);

  run_publication_sync();

  delete_transient('publication_sync_running');
});

// show only if administrator
add_action('wp_ajax_sync_publications', function () {

  if (!current_user_can('manage_options')) {
    wp_send_json_error(['message' => 'Unauthorized']);
  }

  run_publication_sync();

  wp_send_json_success([
    'message' => 'Zotero sync complete'
  ]);
});

// show what is syns status
function publication_sync_log($data)
{
  $log = get_option('publication_sync_log', []);
  $log = array_merge($log, $data);
  update_option('publication_sync_log', $log, false);
}
