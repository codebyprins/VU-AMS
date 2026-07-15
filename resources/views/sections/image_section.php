<?php

$title = get_sub_field('image_section_title');
$image_1 = get_sub_field('image_section_image_1');
$image_2 = get_sub_field('image_section_image_2');

if (!$image_1 && !$image_2) {
    return;
}

?>

<section class="bg-[#F8F8F8] py-10 md:py-16">
    <div class="container mx-auto px-4">

        <?php if ($title): ?>
            <h2 class="text-3xl md:text-4xl font-bold mb-8 text-center">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>


        <div class="<?php echo ($image_1 && $image_2) ? 'grid grid-cols-1 md:grid-cols-2 gap-8' : ''; ?>">

            <?php if ($image_1): ?>
                <div class="overflow-hidden rounded-3xl flex items-center justify-center h-[500px]">
                    <img
                        src="<?php echo esc_url($image_1['url']); ?>"
                        alt="<?php echo esc_attr($image_1['alt']); ?>"
                        class="w-full h-full object-contain"
                    >
                </div>
            <?php endif; ?>


            <?php if ($image_2): ?>
                <div class="overflow-hidden rounded-3xl flex items-center justify-center h-[500px]">
                    <img
                        src="<?php echo esc_url($image_2['url']); ?>"
                        alt="<?php echo esc_attr($image_2['alt']); ?>"
                        class="w-full h-full object-contain"
                    >
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>