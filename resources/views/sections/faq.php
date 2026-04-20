<?php

$faq_items = get_sub_field('faq_items');

?>

<section class="bg-white py-10">
    <div class="container mx-auto px-4 flex justify-center items-center">
        <div class="faq_items">
            <?php foreach ($faq_items as $faq_item) : ?>
                <div class="faq_item mb-5 border-b border-black max-w-[600px]">
                    <div class="faq_header flex items-center justify-between">
                        <h3 class="text-2xl mb-4"><?php echo $faq_item['question']; ?></h3>

                        <svg class="faq_icon faq_icon--plus mb-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4V20M20 12H4" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <svg class="faq_icon faq_icon--minus hidden mb-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 12L4 12" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </div>
                    <div class="faq_content">
                        <div class="rich-editor px-4 pb-4 text-black"><?php echo $faq_item['answer']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>