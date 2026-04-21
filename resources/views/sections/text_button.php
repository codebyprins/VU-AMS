<?php
$title     = get_sub_field('title_text_button');
$text      = get_sub_field('text_text_button');
$button    = get_sub_field('button_text-button');
$reverse   = get_sub_field('reverse-text-button');
$darklight = get_sub_field('darklight');
?>


<section class="section" <?php if ($darklight) : ?>style="background-color: #F8F8F8;"<?php endif; ?>>
    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <div class="container col-span-1 flex flex-col gap-4 py-[10px] justify-center <?php echo $reverse ? 'order-1 md:order-2' : 'order-2 md:order-1'; ?>">
                <?php if ($title) : ?>
                    <h2 class="text-xl font-bold text-accent"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($text) : ?>
                    <div class="prose max-w-none text-base"><?php echo wp_kses_post($text); ?></div>
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
            <div class="col-span-1 relative min-h-[300px] md:min-h-[400px] <?php echo $reverse ? 'order-2 md:order-1' : 'order-1 md:order-2'; ?>">
                <?php $image = get_sub_field('text-button-image'); ?>
                <?php if ($image) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="absolute inset-0 w-full h-full object-cover" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
