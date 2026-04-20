<?php

function custom_pagination($query) {
    $total_pages = $query->max_num_pages;
    if ($total_pages <= 1) return;

    $current_page = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);
    $base = str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999)));

    echo '<div class="pagination mt-8 flex justify-center items-center gap-2">';

    if ($current_page > 1) {
        $prev_link = str_replace('%#%', $current_page - 1, $base);
        echo '<a href="' . esc_url($prev_link) . '" class="px-3 py-1 text-black rounded-full hover:opacity-50 transition-all">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.7998 11.9998L14.6998 15.8998C14.8832 16.0831 14.9748 16.3165 14.9748 16.5998C14.9748 16.8831 14.8832 17.1165 14.6998 17.2998C14.5165 17.4831 14.2832 17.5748 13.9998 17.5748C13.7165 17.5748 13.4832 17.4831 13.2998 17.2998L8.69982 12.6998C8.59982 12.5998 8.52915 12.4915 8.48782 12.3748C8.44649 12.2581 8.42549 12.1331 8.42482 11.9998C8.42415 11.8665 8.44515 11.7415 8.48782 11.6248C8.53049 11.5081 8.60115 11.3998 8.69982 11.2998L13.2998 6.6998C13.4832 6.51647 13.7165 6.4248 13.9998 6.4248C14.2832 6.4248 14.5165 6.51647 14.6998 6.6998C14.8832 6.88314 14.9748 7.11647 14.9748 7.3998C14.9748 7.68314 14.8832 7.91647 14.6998 8.0998L10.7998 11.9998Z" fill="black"/>
        </svg>
        </a>';
    }

    $pages = [];
    $pages[] = 1;
    if ($current_page > 3) {
        $pages[] = '...';
    }
    $start = max(2, $current_page - 1);
    $end = min($total_pages - 1, $current_page + 1);
    for ($i = $start; $i <= $end; $i++) {
        $pages[] = $i;
    }
    if ($current_page < $total_pages - 2) {
        $pages[] = '...';
    }
    if ($total_pages > 1) {
        $pages[] = $total_pages;
    }
    $pages = array_unique($pages);

    foreach ($pages as $page) {
        if ($page === '...') {
            echo '<span class="px-3 py-1 bg-[#F8F8F8] text-black rounded-full">...</span>';
        } elseif ($page == $current_page) {
            echo '<span class="px-3 py-1 bg-[#F8F8F8] text-black rounded-full opacity-50">' . $page . '</span>';
        } else {
            $link = str_replace('%#%', $page, $base);
            echo '<a href="' . esc_url($link) . '" class="px-3 py-1 bg-[#F8F8F8] text-black rounded-full hover:opacity-50 transition-all">' . $page . '</a>';
        }
    }

    if ($current_page < $total_pages) {
        $next_link = str_replace('%#%', $current_page + 1, $base);
        echo '<a href="' . esc_url($next_link) . '" class="px-3 py-1 text-black rounded-full hover:opacity-50 transition-all">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.5998 11.9998L8.6998 8.0998C8.51647 7.91647 8.4248 7.68314 8.4248 7.3998C8.4248 7.11647 8.51647 6.88314 8.6998 6.6998C8.88314 6.51647 9.11647 6.4248 9.3998 6.4248C9.68314 6.4248 9.91647 6.51647 10.0998 6.6998L14.6998 11.2998C14.7998 11.3998 14.8708 11.5081 14.9128 11.6248C14.9548 11.7415 14.9755 11.8665 14.9748 11.9998C14.9741 12.1331 14.9535 12.2581 14.9128 12.3748C14.8721 12.4915 14.8011 12.5998 14.6998 12.6998L10.0998 17.2998C9.91647 17.4831 9.68314 17.5748 9.3998 17.5748C9.11647 17.5748 8.88314 17.4831 8.6998 17.2998C8.51647 17.1165 8.4248 16.8831 8.4248 16.5998C8.4248 16.3165 8.51647 16.0831 8.6998 15.8998L12.5998 11.9998Z" fill="black"/>
                </svg>
        </a>';
    }

    echo '</div>';
}