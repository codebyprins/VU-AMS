<?php
function theme_enqueue_assets() {
    // Swiper CSS
    wp_enqueue_style(
        'swiper-style',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css'
    );

    // Tailwind CSS
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/public/css/app.css',
        [],
        filemtime(get_template_directory() . '/public/css/app.css')
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper-script',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        null,
        true
    );

    // JS
    wp_enqueue_script(
        'theme-app',
        get_template_directory_uri() . '/public/js/main.js',
        ['swiper-script'],
        filemtime(get_template_directory() . '/public/js/main.js'),
        true
    );

    // Initialize Swiper
    wp_add_inline_script('theme-app', '
    document.addEventListener("DOMContentLoaded", function() {
        const swiper = new Swiper(".swiper", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            slidesPerView: 1,
            spaceBetween: 0,
        });
    });
    ');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

// Enqueue admin scripts
function theme_enqueue_admin_assets() {
    wp_enqueue_script(
        'sync-publications',
        get_template_directory_uri() . '/resources/scripts/api-sync.js',
        ['jquery'],
        filemtime(get_template_directory() . '/resources/scripts/api-sync.js'),
        true
    );
    
    wp_localize_script('sync-publications', 'syncSettings', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sync_publications_nonce'),
    ]);
}
add_action('admin_enqueue_scripts', 'theme_enqueue_admin_assets');