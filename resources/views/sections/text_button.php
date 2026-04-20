<?php
$title   = get_sub_field('title_text_button');
$text    = get_sub_field('text_text_button');
$button  = get_sub_field('button_text-button');
$reverse = get_sub_field('reverse-text-button');
?>


<section class="section">
    <div class="container py-8">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div class="container col-span-1 flex flex-col gap-4 <?php echo $reverse ? 'order-2' : 'order-1'; ?>">
                <?php if ($title) : ?>
                    <h2 class="text-xl font-bold text-accent"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($text) : ?>
                    <div class="prose max-w-none"><?php echo wp_kses_post($text); ?></div>
                <?php endif; ?>
                <?php if ($button) : ?>
                    <a
                        href="<?php echo esc_url($button['url']); ?>"
                        class="btn btn-primary w-[fit-content]"
                        <?php if (!empty($button['target'])) : ?>target="<?php echo esc_attr($button['target']); ?>"<?php endif; ?>
                    >
                        <?php echo esc_html($button['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-span-1 p-4 <?php echo $reverse ? 'order-1' : 'order-2'; ?>">
            </div>
        </div>
    </div>
</section>
