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

  // Register custom meta fields for REST API
  $meta_fields = [
    'publication_year',
    'publication_authors',
    'publication_keywords',
    'publication_source',
    'publication_date',
    'publication_url',
    'doi',
    'publication_title',
    'external_id',
  ];

  foreach ($meta_fields as $field) {
    register_rest_field('publication', $field, [
      'get_callback' => function ($post) use ($field) {
        return get_post_meta($post['id'], $field, true);
      },
      'schema' => [
        'type' => 'string',
        'context' => ['view', 'edit'],
      ],
    ]);
  }

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

add_action('restrict_manage_posts', function ($post_type) {
  if ($post_type !== 'publication') {
    return;
  }

  $selected_year = sanitize_text_field(wp_unslash($_GET['publication_year'] ?? ''));
  $years = get_terms([
    'taxonomy' => 'publication_year',
    'hide_empty' => true,
  ]);

  if (is_wp_error($years) || empty($years)) {
    return;
  }

  usort($years, function ($a, $b) {
    return (int) $b->name <=> (int) $a->name;
  });
?>
  <select name="publication_year" id="filter-by-publication-year">
    <option value=""><?php esc_html_e('All years', 'vu-ams'); ?></option>
    <?php foreach ($years as $year) : ?>
      <option value="<?php echo esc_attr($year->slug); ?>" <?php selected($selected_year, $year->slug); ?>>
        <?php echo esc_html($year->name); ?>
      </option>
    <?php endforeach; ?>
  </select>
<?php
});

add_filter('manage_edit-publication_sortable_columns', function ($columns) {
  $columns['taxonomy-publication_year'] = 'publication_year';

  return $columns;
});

add_action('pre_get_posts', function ($query) {
  if (
    !is_admin()
    || !$query->is_main_query()
    || $query->get('post_type') !== 'publication'
    || $query->get('orderby') !== 'publication_year'
  ) {
    return;
  }

  $query->set('meta_key', 'publication_year');
  $query->set('orderby', 'meta_value_num');
});

//run the sync functions

function run_publication_sync()
{
  set_time_limit(120);
  publication_sync_update_status([
    'running' => true,
    'done' => false,
    'stage' => 'Starting',
    'message' => 'Starting publication sync...',
    'processed' => 0,
    'total' => 0,
    'zotero_updated' => 0,
    'scholar_updated' => 0,
    'archived' => 0,
    'log' => [],
  ], true);

  publication_sync_title_seen('', true);
  publication_sync_token(uniqid('publication_sync_', true));

  $zotero_result  = sync_zotero_publications();
  $scholar_result = sync_google_scholar_publications();

  $completed_sources = [];

  if ($zotero_result['completed']) {
    $completed_sources[] = 'Zotero';
  }

  if ($scholar_result['completed']) {
    $completed_sources[] = 'Google Scholar';
  }

  publication_sync_update_status([
    'stage' => 'Archiving',
    'message' => 'Checking for publications missing from completed sources...',
  ]);

  $archived_count = archive_missing_publications($completed_sources);

  publication_sync_log([
    'last_run_start'  => current_time('mysql'),
    'last_run_end'    => current_time('mysql'),
    'zotero_updated'  => $zotero_result['updated'],
    'scholar_updated' => $scholar_result['updated'],
    'archived'        => $archived_count,
    'total_updated'   => $zotero_result['updated'] + $scholar_result['updated'],
    'total_posts'     => wp_count_posts('publication')->publish,
  ]);

  publication_sync_update_status([
    'running' => false,
    'done' => true,
    'stage' => 'Complete',
    'message' => 'Publication sync complete',
    'processed' => publication_sync_status_value('total'),
    'zotero_updated' => $zotero_result['updated'],
    'scholar_updated' => $scholar_result['updated'],
    'archived' => $archived_count,
  ]);

  return publication_sync_result(
    $zotero_result['updated'] + $scholar_result['updated'],
    true
  );
}

function normalize_publication_title($title)
{
  $title = html_entity_decode(wp_strip_all_tags((string) $title), ENT_QUOTES, get_bloginfo('charset'));
  $title = remove_accents($title);
  $title = strtolower($title);
  $title = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $title);

  return trim(preg_replace('/\s+/', ' ', $title));
}

function get_publication_by_normalized_title($normalized_title, $external_id = '')
{
  if (!$normalized_title) {
    return 0;
  }

  $posts = get_posts([
    'post_type'      => 'publication',
    'post_status'    => 'any',
    'fields'         => 'ids',
    'posts_per_page' => 1,
    'meta_query'     => [
      [
        'key'   => 'normalized_title',
        'value' => $normalized_title,
      ],
    ],
  ]);

  $post_id = $posts[0] ?? 0;
  if (!$post_id || !$external_id) {
    return $post_id;
  }

  return get_post_meta($post_id, 'external_id', true) === $external_id ? 0 : $post_id;
}

function is_zotero_publication_data($data)
{
  return ($data['source'] ?? '') === 'Zotero'
    || strpos($data['external_id'] ?? '', 'zotero_') === 0;
}

function publication_sync_title_seen($normalized_title, $reset = false)
{
  static $seen_titles = [];

  if ($reset) {
    $seen_titles = [];
    return false;
  }

  if (!$normalized_title) {
    return true;
  }

  if (isset($seen_titles[$normalized_title])) {
    return true;
  }

  $seen_titles[$normalized_title] = true;
  return false;
}

function publication_sync_token($token = null)
{
  static $current_token = '';

  if ($token !== null) {
    $current_token = $token;
  }

  return $current_token;
}

function publication_sync_result($updated, $completed)
{
  return [
    'updated'   => $updated,
    'completed' => $completed,
  ];
}

function publication_sync_default_status()
{
  return [
    'running' => false,
    'done' => false,
    'stage' => 'Idle',
    'message' => '',
    'processed' => 0,
    'total' => 0,
    'zotero_updated' => 0,
    'scholar_updated' => 0,
    'archived' => 0,
    'log' => [],
  ];
}

function publication_sync_status_value($key)
{
  $status = get_option('publication_sync_status', publication_sync_default_status());

  return $status[$key] ?? publication_sync_default_status()[$key] ?? null;
}

function publication_sync_update_status($data, $replace = false)
{
  $status = $replace
    ? publication_sync_default_status()
    : get_option('publication_sync_status', publication_sync_default_status());

  $status = array_merge($status, $data);

  if (!empty($data['log_entry'])) {
    $status['log'][] = [
      'time' => current_time('H:i:s'),
      'text' => sanitize_text_field($data['log_entry']),
    ];

    $status['log'] = array_slice($status['log'], -80);
    unset($status['log_entry']);
  }

  $total = (int) ($status['total'] ?? 0);
  $processed = (int) ($status['processed'] ?? 0);
  $status['percent'] = $total > 0
    ? min(100, (int) floor(($processed / $total) * 100))
    : 0;

  update_option('publication_sync_status', $status, false);
}

function publication_sync_increment_total($amount)
{
  $amount = max(0, (int) $amount);

  if (!$amount) {
    return;
  }

  publication_sync_update_status([
    'total' => ((int) publication_sync_status_value('total')) + $amount,
  ]);
}

function publication_sync_progress($source, $processed, $updated, $force = false)
{
  publication_sync_update_status([
    'stage' => $source,
    'message' => sprintf('%s sync: %d publications processed, %d updated.', $source, $processed, $updated),
    'processed' => $force
      ? (int) publication_sync_status_value('processed')
      : (int) publication_sync_status_value('processed') + 1,
  ]);

  if ($force || $processed % 10 === 0) {
    publication_sync_update_status([
      'log_entry' => sprintf('%s: processed %d publications, updated %d.', $source, $processed, $updated),
    ]);
  }
}

function mark_publication_seen_in_sync($post_id)
{
  $token = publication_sync_token();

  if ($token) {
    update_post_meta($post_id, '_publication_sync_token', $token);
  }
}

function publication_post_matches_source($post_id, $source)
{
  $external_id = get_post_meta($post_id, 'external_id', true);

  if ($source === 'Zotero' && strpos($external_id, 'zotero_') === 0) {
    return true;
  }

  if ($source === 'Google Scholar' && strpos($external_id, 'scholar_') === 0) {
    return true;
  }

  $sources = get_the_terms($post_id, 'publication_source');
  if (!$sources || is_wp_error($sources)) {
    return false;
  }

  return in_array($source, wp_list_pluck($sources, 'name'), true);
}

function archive_missing_publications($completed_sources)
{
  if (empty($completed_sources)) {
    return 0;
  }

  $token = publication_sync_token();
  if (!$token) {
    return 0;
  }

  $post_ids = get_posts([
    'post_type'      => 'publication',
    'post_status'    => 'publish',
    'fields'         => 'ids',
    'posts_per_page' => -1,
    'meta_query'     => [
      [
        'key'     => 'external_id',
        'compare' => 'EXISTS',
      ],
    ],
  ]);

  $archived = 0;

  foreach ($post_ids as $post_id) {
    if (get_post_meta($post_id, '_publication_sync_token', true) === $token) {
      continue;
    }

    $matches_completed_source = false;
    foreach ($completed_sources as $source) {
      if (publication_post_matches_source($post_id, $source)) {
        $matches_completed_source = true;
        break;
      }
    }

    if (!$matches_completed_source) {
      continue;
    }

    $updated = wp_update_post([
      'ID'          => $post_id,
      'post_status' => 'draft',
    ], true);

    if (!is_wp_error($updated)) {
      $archived++;
    }
  }

  return $archived;
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
  $normalized_title = normalize_publication_title($data['title'] ?? '');
  $duplicate_post_id = !$post_id
    ? get_publication_by_normalized_title($normalized_title, $data['external_id'])
    : 0;

  if ($duplicate_post_id) {
    if (!is_zotero_publication_data($data)) {
      return false;
    }

    $post_id = $duplicate_post_id;
  }

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
  update_post_meta($post_id, 'normalized_title', $normalized_title);
  mark_publication_seen_in_sync($post_id);

  // YEAR - Store as both taxonomy and meta
  if (!empty($data['year'])) {
    wp_set_object_terms(
      $post_id,
      [$data['year']],
      'publication_year'
    );
    update_post_meta($post_id, 'publication_year', sanitize_text_field($data['year']));
  }

  // AUTHORS - Store as both taxonomy and meta
  if (!empty($data['authors'])) {
    wp_set_object_terms(
      $post_id,
      $data['authors'],
      'publication_author'
    );
    update_post_meta($post_id, 'publication_authors', wp_json_encode($data['authors']));
  }

  // KEYWORDS - Store as both taxonomy and meta
  if (!empty($data['keywords'])) {
    wp_set_object_terms(
      $post_id,
      $data['keywords'],
      'publication_keyword'
    );
    update_post_meta($post_id, 'publication_keywords', wp_json_encode($data['keywords']));
  }

  // SOURCE - Store as both taxonomy and meta
  if (!empty($data['source'])) {
    wp_set_object_terms(
      $post_id,
      [$data['source']],
      'publication_source'
    );
    update_post_meta($post_id, 'publication_source', sanitize_text_field($data['source']));
  }

  // PUBLICATION DATE
  if (!empty($data['publication_date'])) {
    update_post_meta($post_id, 'publication_date', sanitize_text_field($data['publication_date']));
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
  $processed = 0;

  $group_id = get_field('zotero_group_id', 'option');
  if (!$group_id) return publication_sync_result(0, false);

  $start = 0;
  $limit = 100;
  $total_known = false;

  while (true) {
    $url = "https://api.zotero.org/groups/{$group_id}/items?format=json&limit={$limit}&start={$start}";
    $response = wp_remote_get($url, [
      'timeout' => 20,
    ]);

    if (is_wp_error($response)) return publication_sync_result($updated, false);

    if (wp_remote_retrieve_response_code($response) !== 200) {
      return publication_sync_result($updated, false);
    }

    if ($start === 0) {
      $total_results = (int) wp_remote_retrieve_header($response, 'Total-Results');
      if ($total_results > 0) {
        $total_known = true;
        publication_sync_increment_total($total_results);
      }
    }

    $items = json_decode(wp_remote_retrieve_body($response), true);
    if (!is_array($items)) return publication_sync_result($updated, false);
    if (empty($items)) break;
    if (!$total_known) {
      publication_sync_increment_total(count($items));
    }

    foreach ($items as $item) {
      $data = $item['data'] ?? [];
      if (!$data || in_array($data['itemType'], ['note', 'attachment'])) continue;

      $processed++;
      $title = $data['title'] ?? '';
      $normalized_title = normalize_publication_title($title);
      if (publication_sync_title_seen($normalized_title)) {
        publication_sync_progress('Zotero', $processed, $updated);
        continue;
      }

      $post_id = upsert_publication([
        'external_id' => 'zotero_' . $item['key'],
        'title'       => $title,
        'content'     => $data['abstractNote'] ?? '',
        'excerpt'     => wp_trim_words($data['abstractNote'] ?? '', 30),

        'publication_date' => $data['date'] ?? '',
        
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
      publication_sync_progress('Zotero', $processed, $updated);
    }

    if (count($items) < $limit) break;
    $start += $limit;
  }

  if ($processed > 0 && $processed % 10 !== 0) {
    publication_sync_progress('Zotero', $processed, $updated, true);
  }

  return publication_sync_result($updated, true);
}


// fetch data from google scholar using serpapi and safe as post
function sync_google_scholar_publications()
{
  $updated = 0;
  $processed = 0;

  $api_key   = get_field('serpapi_api_key', 'option');
  $author_id = get_field('google_scholar_author_id', 'option');

  if (!$api_key || !$author_id) return publication_sync_result(0, false);

  $start = 0;
  $limit = 20;
  $pages = 0;

  do {
    $url = add_query_arg([
      'engine'    => 'google_scholar_author',
      'author_id' => $author_id,
      'api_key'   => $api_key,
      'start'     => $start,
    ], 'https://serpapi.com/search.json');

    $response = wp_remote_get($url, [
      'timeout' => 20,
    ]);
    if (is_wp_error($response)) return publication_sync_result($updated, false);

    if (wp_remote_retrieve_response_code($response) !== 200) {
      return publication_sync_result($updated, false);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (!is_array($body)) return publication_sync_result($updated, false);

    $articles = $body['articles'] ?? [];
    publication_sync_increment_total(count($articles));

    foreach ($articles as $article) {
      $processed++;
      $title = $article['title'] ?? '';
      $normalized_title = normalize_publication_title($title);
      if (publication_sync_title_seen($normalized_title)) {
        publication_sync_progress('Google Scholar', $processed, $updated);
        continue;
      }

      $external_id = !empty($article['citation_id'])
        ? 'scholar_' . $article['citation_id']
        : 'scholar_' . md5($title);

      $post_id = upsert_publication([
        'external_id' => $external_id,
        'title'       => $title,
        'year'        => $article['year'] ?? '',
        'authors'     => !empty($article['authors'])
          ? array_map('trim', explode(',', $article['authors']))
          : [],
        'source'      => 'Google Scholar',
        'url'         => $article['link'] ?? '',
        'publication_title' => $article['publication'] ?? '',
      ]);

      if ($post_id) $updated++;
      publication_sync_progress('Google Scholar', $processed, $updated);
    }

    $start += $limit;
    $pages++;

    if ($pages >= 10 && count($articles) === $limit) {
      return publication_sync_result($updated, false);
    }

    if ($pages >= 10) break;
  } while (count($articles) === $limit);

  if ($processed > 0 && $processed % 10 !== 0) {
    publication_sync_progress('Google Scholar', $processed, $updated, true);
  }

  return publication_sync_result($updated, true);
}

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

  check_ajax_referer('publication_sync', 'nonce');

  if (get_transient('publication_sync_running')) {
    wp_send_json_error([
      'message' => 'Publication sync is already running.',
      'status' => get_option('publication_sync_status', publication_sync_default_status()),
    ]);
  }

  set_transient('publication_sync_running', true, 15 * MINUTE_IN_SECONDS);

  $result = run_publication_sync();

  delete_transient('publication_sync_running');

  wp_send_json_success([
    'message' => 'Publication sync complete',
    'status' => get_option('publication_sync_status', publication_sync_default_status()),
  ]);
});

add_action('wp_ajax_publication_sync_status', function () {

  if (!current_user_can('manage_options')) {
    wp_send_json_error(['message' => 'Unauthorized']);
  }

  check_ajax_referer('publication_sync', 'nonce');

  wp_send_json_success([
    'status' => get_option('publication_sync_status', publication_sync_default_status()),
  ]);
});

// show what is syns status
function publication_sync_log($data)
{
  $log = get_option('publication_sync_log', []);
  $log = array_merge($log, $data);
  update_option('publication_sync_log', $log, false);
}
