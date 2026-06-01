<?php

$title = get_sub_field('title');

$faq_posts = get_posts([
    'post_type' => 'faq',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

?>

<section class="bg-white py-10">
    <div id="faq" class="container mx-auto px-4 flex justify-center items-center">
        <div class="faq_items max-w-[600px]">
            <h2 class="text-4xl font-bold mb-14 text-center"><?php echo esc_html($title); ?></h2>
            <?php foreach ($faq_posts as $faq_post) : ?>
                <div class="faq_item mb-5 border-b border-black">
                    <div class="faq_header flex items-center justify-between">
                        <h3 class="text-2xl mb-4 max-w-[95%]"><?php echo esc_html($faq_post->post_title); ?></h3>

                        <svg class="faq_icon faq_icon--plus mb-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4V20M20 12H4" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <svg class="faq_icon faq_icon--minus hidden mb-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 12L4 12" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </div>
                    <div class="faq_content">
                        <div class="rich-editor px-4 pb-4 text-black"><?php echo get_field('answer', $faq_post->ID); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>