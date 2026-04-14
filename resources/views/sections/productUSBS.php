<?php

$title   = get_sub_field('title_productUSBS');
$projecthighlight    = get_sub_field('text_text_button');
$button  = get_sub_field('button_text-button');
$image = get_sub_field('image_productUSBS');
$highlights = get_sub_field('highlights_productUSBS') ?: [];

?>

<section class="min-h-[78vh] bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-20" aria-label="Product hero">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-2">

            <div class="space-y-8 md:pr-6">
                <h1 class="text-4xl font-bold leading-[1.05] text-accent sm:text-5xl"><?php echo esc_html($title); ?></h1>
                <div class="aspect-square w-full max-w-[380px] overflow-hidden rounded-3xl border-2 border-secondary bg-white p-4 shadow-lg">
                    <img class="block h-full w-full object-contain"
                         src="<?php echo esc_url($image['url'] ?? ''); ?>"
                         alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
                         loading="eager" fetchpriority="high" decoding="async">
                </div>
            </div>

            <div>
                <?php foreach ($highlights as $i => $h) : ?>
                    <div class="py-5<?php echo $i < $last ? ' border-b border-secondary' : ''; ?>">
                        <div class="flex items-start gap-3">
                            <span class="<?php echo esc_attr($h['icon'] ?? 'fa-solid fa-circle-check'); ?> mt-1 text-primary" aria-hidden="true"></span>
                            <h3 class="text-xl font-semibold text-accent"><?php echo esc_html($h['title'] ?? ''); ?></h3>
                        </div>
                        <?php if (!empty($h['description'])) : ?>
                            <p class="mt-2 text-base leading-relaxed text-slate-600"><?php echo esc_html($h['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>