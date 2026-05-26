<?php
function theme_enqueue_assets()
{
    
    // Choices.js CSS
    wp_enqueue_style(
        'choices-css',
        'https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css',
        [],
        null
    );

    // Choices.js JS
    wp_enqueue_script(
        'choices-js',
        'https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js',
        [],
        null,
        true
    );
    
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

function theme_enqueue_admin_assets()
{
    wp_enqueue_script(
        'publication-api-sync',
        get_template_directory_uri() . '/resources/scripts/api-sync.js',
        ['jquery'],
        filemtime(get_template_directory() . '/resources/scripts/api-sync.js'),
        true
    );

    wp_localize_script('publication-api-sync', 'vuAmsPublicationSync', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('publication_sync'),
    ]);
}
add_action('admin_enqueue_scripts', 'theme_enqueue_admin_assets');
