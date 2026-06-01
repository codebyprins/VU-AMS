<?php

add_filter('posts_search', 'improved_search_query', 10, 2);

function improved_search_query($search, $wp_query)
{
    if (empty($search)) {
        return $search;
    }

    global $wpdb;

    $search_term = $wp_query->get('s');
    if (empty($search_term)) {
        return $search;
    }

    $search_term = esc_sql($search_term);
    
    $search_words = array_filter(explode(' ', $search_term));
    
    if (empty($search_words)) {
        return $search;
    }

    $search_conditions = [];
    
    foreach ($search_words as $word) {
        $word_conditions = [];
        $word_conditions[] = "({$wpdb->posts}.post_title LIKE '%{$word}%')";
        $word_conditions[] = "({$wpdb->posts}.post_content LIKE '%{$word}%')";
        $word_conditions[] = "({$wpdb->posts}.post_excerpt LIKE '%{$word}%')";
        
        $search_conditions[] = '(' . implode(' OR ', $word_conditions) . ')';
    }

    $improved_search = ' AND (' . implode(' AND ', $search_conditions) . ') ';

    return $improved_search;
}

add_filter('posts_orderby', 'improved_search_orderby', 10, 2);

function improved_search_orderby($orderby, $wp_query)
{
    if (!$wp_query->is_search()) {
        return $orderby;
    }

    global $wpdb;
    
    $search_term = $wp_query->get('s');
    if (empty($search_term)) {
        return $orderby;
    }

    $search_term = esc_sql($search_term);
    
    $orderby = "CASE 
        WHEN {$wpdb->posts}.post_title LIKE '%{$search_term}%' THEN 1
        WHEN {$wpdb->posts}.post_title LIKE '%{$search_term}%' THEN 2
        ELSE 3
    END ASC, {$wpdb->posts}.post_date DESC";

    return $orderby;
}
