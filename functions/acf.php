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
        <div
            id="publication-sync-modal"
            class="publication-sync-modal"
            role="dialog"
            aria-modal="true"
            aria-labelledby="publication-sync-modal-title"
            style="display:none;">
            <div class="publication-sync-modal__panel">
                <h2 id="publication-sync-modal-title">Publication sync</h2>
                <p id="publication-sync-modal-message">Starting publication sync...</p>
                <div class="publication-sync-modal__bar" aria-hidden="true">
                    <div id="publication-sync-progress-bar" class="publication-sync-modal__bar-fill" style="width:0%;"></div>
                </div>
                <div class="publication-sync-modal__meta">
                    <span id="publication-sync-progress-text">0%</span>
                    <span id="publication-sync-count-text">0 / 0</span>
                </div>
                <div id="publication-sync-log" class="publication-sync-modal__log" aria-live="polite"></div>
                <button type="button" class="button button-secondary" id="publication-sync-close" disabled>
                    Close
                </button>
            </div>
        </div>
        <style>
            .publication-sync-modal {
                position: fixed;
                inset: 0;
                z-index: 100000;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(0, 0, 0, 0.45);
            }

            .publication-sync-modal__panel {
                width: min(560px, calc(100vw - 40px));
                padding: 24px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            }

            .publication-sync-modal__panel h2 {
                margin-top: 0;
            }

            .publication-sync-modal__bar {
                height: 18px;
                overflow: hidden;
                background: #e5e5e5;
                border-radius: 999px;
            }

            .publication-sync-modal__bar-fill {
                height: 100%;
                background: #2271b1;
                transition: width 0.2s ease;
            }

            .publication-sync-modal__meta {
                display: flex;
                justify-content: space-between;
                margin-top: 8px;
                color: #50575e;
            }

            .publication-sync-modal__log {
                height: 180px;
                margin: 16px 0;
                padding: 12px;
                overflow: auto;
                background: #f6f7f7;
                border: 1px solid #dcdcde;
                border-radius: 4px;
                font-family: monospace;
                font-size: 12px;
                line-height: 1.5;
            }

            .publication-sync-modal__log p {
                margin: 0 0 4px;
            }
        </style>
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
