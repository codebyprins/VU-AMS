<?php

// here go the acf settings, field groups, etc.

//remove standard editor from almost allposts and pages, use acf for input.
// (DONT TURN OFF FOR PUBLICATIONS, THE SYNC PUTS CONTENT IN IT)
function remove_editor_globally()
{
    remove_post_type_support('post', 'editor');
    remove_post_type_support('support_blog', 'editor');
    remove_post_type_support('product', 'editor');
    remove_post_type_support('project', 'editor');
    remove_post_type_support('software-release', 'editor');
    remove_post_type_support('team-member', 'editor');  
    remove_post_type_support('location', 'editor');
    remove_post_type_support('page', 'editor');
}
add_action('init', 'remove_editor_globally');

add_action('acf/render_field/name=publications_api_sync', function () {

    $log = get_option('publication_sync_log', []);
?>
    <div style="padding:10px;background:#fff;border:1px solid #ddd;">
        <button type="button" class="button button-primary" id="sync-publications">
            Sync Publications
        </button>
        <div id="sync-status" style="margin-top:10px;"></div>
        <hr>
        <strong>Last Sync Info</strong><br>
        <p> Last sync: <?php echo esc_html($log['last_run_end'] ?? '-'); ?></p>
        <p>Total in DB: <?php echo esc_html($log['total_posts'] ?? wp_count_posts('publication')->publish); ?></p><br>

        <p>Zotero Updated: <?php echo esc_html($log['zotero_updated'] ?? 0); ?></p>
        <p>Scholar Updated: <?php echo esc_html($log['scholar_updated'] ?? 0); ?></p>
        <p>Archived: <?php echo esc_html($log['archived'] ?? 0); ?></p>
        <p>Total Updated: <?php echo esc_html($log['total_updated'] ?? 0); ?></p>

    </div>
<?php
});

add_action('init', function () {

    add_filter(
        'acf/load_field/key=field_6a0eb3d7467a5',
        'load_publication_keyword_choices'
    );
});

function load_publication_keyword_choices($field)
{
    $field['choices'] = [];

    $terms = get_terms([
        'taxonomy'   => 'publication_keyword',
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    if (is_wp_error($terms)) {
        return $field;
    }

    foreach ($terms as $term) {

        $field['choices'][$term->slug] = $term->name;
    }

    return $field;
}
