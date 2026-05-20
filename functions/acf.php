<?php

// here go the acf settings, field groups, etc.

//remove standard editor from posts and pages, use acf for input
function remove_editor_globally()
{
    remove_post_type_support('post', 'editor');
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
        <p> Last Run Start: <?php echo esc_html($log['last_run_start'] ?? '-'); ?></p>
        <p> Last Run End: <?php echo esc_html($log['last_run_end'] ?? '-'); ?></p>
        <p>Total in DB: <?php echo esc_html($log['total_posts'] ?? wp_count_posts('publication')->publish); ?></p><br>

        <p>Zotero Updated: <?php echo esc_html($log['zotero_updated'] ?? 0); ?></p>
        <p>Scholar Updated: <?php echo esc_html($log['scholar_updated'] ?? 0); ?></p>
        <p>Total Updated: <?php echo esc_html($log['total_updated'] ?? 0); ?></p>

    </div>
<?php
});
