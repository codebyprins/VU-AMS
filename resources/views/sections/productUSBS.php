<?php

$projecthighlight = get_sub_field('highlights_productusbs');
$image = get_sub_field('image_productusbs');

if (!$projecthighlight) {
    $projecthighlight = get_sub_field('highlights_productusbs');
}
if (!$image) {
    $image = get_sub_field('image_productusbs');
}

$highlights = [];

if (have_rows('highlights_productusbs')) {
    while (have_rows('highlights_productusbs')) {
        the_row();
        $highlights[] = [
            'title' => get_sub_field('title'),
            'content' => get_sub_field('content'),
        ];
    }
} elseif (have_rows('highlights_productusbs')) {
    while (have_rows('highlights_productusbs')) {
        the_row();
        $highlights[] = [
            'title' => get_sub_field('title'),
            'content' => get_sub_field('content'),
        ];
    }
} elseif (is_array($projecthighlight)) {
    foreach ($projecthighlight as $row) {
        if (!is_array($row)) {
            continue;
        }

        $highlights[] = [
            'title' => $row['title'] ?? '',
            'content' => $row['content'] ?? '',
        ];
    }
}

$hero_image_url = '';
$hero_image_alt = '';
$image_id = 0;

if (is_array($image)) {
    $image_id = (int) ($image['ID'] ?? $image['id'] ?? 0);
    $hero_image_url = $image['url'] ?? '';
    $hero_image_alt = $image['alt'] ?? '';
} elseif (is_numeric($image)) {
    $image_id = (int) $image;
} elseif (is_string($image)) {
    $hero_image_url = $image;
}

$last = count($highlights) - 1;

?>

<section class="productusbs-section min-h-[78vh] bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-20" aria-label="Product hero">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-2">

            <div class="space-y-8 md:pr-6">
                <?php if ($image_id || $hero_image_url) : ?>
                    <div class="aspect-square w-full max-w-[380px] overflow-hidden rounded-3xl p-0">
                        <?php if ($image_id) : ?>
                            <?php echo wp_get_attachment_image($image_id, 'large', false, ['class' => 'block h-full w-full object-contain']); ?>
                        <?php else : ?>
                            <img class="block h-full w-full object-contain"
                                 src="<?php echo esc_url($hero_image_url); ?>"
                                 alt="<?php echo esc_attr($hero_image_alt); ?>"
                                 loading="eager" fetchpriority="high" decoding="async">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <?php foreach ($highlights as $i => $h) : ?>
                    <div class="py-5 border-b border-primary last:border-b-0">
                        <details class="group">
                            <summary class="flex cursor-pointer items-center justify-between gap-4 list-none text-left">
                                <span class="text-xl font-bold"><?php echo esc_html($h['title'] ?? ''); ?></span>
                                <span class="text-primary transition duration-200 productusbs-toggle-icon">+</span>
                            </summary>
                            <?php if (!empty($h['content'])) : ?>
                                <div class="mt-2">
                                    <?php echo wp_kses_post($h['content']); ?>
                                </div>
                            <?php endif; ?>
                        </details>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>