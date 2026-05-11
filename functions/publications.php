<?php

// register the post type and taxaonmies
add_action('init', function () {

  // post type
  register_post_type('publication', [
    'label' => 'Publications',
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'publications'],
    'menu_icon' => 'dashicons-book',
    'supports' => ['title', 'editor', 'excerpt'],
    'show_in_rest' => true,
  ]);

  // taxonomies
  $taxonomies = [
    'publication_year'    => 'Year',
    'publication_author'  => 'Author',
    'publication_type'    => 'Type',
    'publication_keyword' => 'Keyword',
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


// admin sync option under posttype menu
add_action('admin_menu', function () {
  add_submenu_page(
    'edit.php?post_type=publication',
    'Sync Publications',
    'Sync',
    'manage_options',
    'sync-publications',
    'render_publication_sync_page'
  );
});

//make the rende page

function render_publication_sync_page()
{
  if (!empty($_POST['sync_publications'])) {
    sync_zotero_publications();
    echo '<div class="notice notice-success"><p>Publications synced.</p></div>';
  }
?>
  <div class="wrap">
    <h1>Sync Publications</h1>
    <form method="post">
      <?php wp_nonce_field('sync_publications'); ?>
      <button
        type="submit"
        name="sync_publications"
        class="button button-primary">
        Sync Zotero
      </button>
    </form>
  </div>
<?php
}


// sync Zotera

function sync_zotero_publications()
{
  $group_id = ZOTERO_GROUP_ID;

  if (!$group_id) {
    return;
  }

  $url = "https://api.zotero.org/groups/{$group_id}/items/top?format=json";

  $response = wp_remote_get($url);

  if (is_wp_error($response)) {
    return;
  }

  $items = json_decode(
    wp_remote_retrieve_body($response),
    true
  );

  if (!$items) {
    return;
  }

  foreach ($items as $item) {
    $data = $item['data'] ?? [];

    // dont add the attachments
    if (
      empty($data) ||
      in_array($data['itemType'], ['attachment', 'note'])
    ) {
      continue;
    }

    $title = trim($data['title'] ?? '');

    if (!$title) {
      continue;
    }


    $has_date = !empty($data['date']);
    $has_authors = !empty($data['creators']);
    $has_tags = !empty($data['tags']);
    $has_type = !empty($data['itemType']);


    if (
      !$has_date ||
      !$has_authors ||
      !$has_type
    ) {
      continue;
    }

    // check if post exists with the same key
    $existing = get_posts([
      'post_type' => 'publication',
      'posts_per_page' => 1,
      'fields' => 'ids',
      'meta_key' => 'zotero_key',
      'meta_value' => $item['key'],
    ]);

    $post_data = [
      'post_type' => 'publication',
      'post_status' => 'publish',
      'post_title' => $title,
      'post_content' => $data['abstractNote'] ?? '',
      'post_excerpt' => wp_trim_words(
        wp_strip_all_tags($data['abstractNote'] ?? ''),
        40
      ),
    ];

    // if exists updtate, else add
    if ($existing) {
      $post_data['ID'] = $existing[0];
      $post_id = wp_update_post($post_data);
    } else {
      $post_id = wp_insert_post($post_data);
    }

    if (!$post_id || is_wp_error($post_id)) {
      continue;
    }

    // update the meta to prevent duplaticates

    update_post_meta($post_id, 'zotero_key', $item['key']);

    update_post_meta(
      $post_id,
      'publication_url',
      get_publication_url($data)
    );

    update_post_meta(
      $post_id,
      'doi',
      $data['DOI'] ?? ''
    );

    // set year taxanomy
    if (!empty($data['date'])) {
      preg_match('/\d{4}/', $data['date'], $matches);
      if (!empty($matches[0])) {
        wp_set_object_terms(
          $post_id,
          $matches[0],
          'publication_year'
        );
      }
    }

    // set author taxanomy
    if (!empty($data['creators'])) {
      $authors = [];
      foreach ($data['creators'] as $creator) {
        $name = trim(
          ($creator['firstName'] ?? '') .
            ' ' .
            ($creator['lastName'] ?? '')
        );

        if ($name) {
          $authors[] = $name;
        }
      }

      wp_set_object_terms(
        $post_id,
        $authors,
        'publication_author'
      );
    }

    // set tags taxanomy
    if (!empty($data['tags'])) {

      $tags = [];

      foreach ($data['tags'] as $tag) {

        if (!empty($tag['tag'])) {
          $tags[] = $tag['tag'];
        }
      }

      wp_set_object_terms(
        $post_id,
        $tags,
        'publication_keyword'
      );
    }

    //type of publication

    if (!empty($data['itemType'])) {

      wp_set_object_terms(
        $post_id,
        $data['itemType'],
        'publication_type'
      );
    }
  }
}

function get_publication_url($data)
{
  if (!empty($data['DOI'])) {
    return 'https://doi.org/' . ltrim($data['DOI'], '/');
  }

  return $data['url'] ?? '';
}
