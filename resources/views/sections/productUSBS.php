<?php

$img = function_exists('get_field') ? get_field('hero_image') : null;
$acf = function_exists('get_field') ? get_field('hero_highlights') : null;

$hero = [
    'title'     => (function_exists('get_field') && get_field('hero_title')) ?: 'Product Title',
    'image_url' => $img['url'] ?? get_template_directory_uri() . '/resources/images/hero-default.jpg',
    'image_alt' => $img['alt'] ?? 'Product image',
];

$lorem      = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
$fallback   = [
    ['title' => 'Product highlight 1', 'description' => $lorem, 'icon' => 'fa-solid fa-bolt'],
    ['title' => 'Product highlight 2', 'description' => $lorem, 'icon' => 'fa-solid fa-shield-halved'],
    ['title' => 'Product highlight 3', 'description' => $lorem, 'icon' => 'fa-solid fa-chart-line'],
    ['title' => 'Product highlight 4', 'description' => $lorem, 'icon' => 'fa-solid fa-headset'],
];
$highlights = array_slice(is_array($acf) && $acf ? $acf : $fallback, 0, 4);
$last       = count($highlights) - 1;
?>

<section class="min-h-[78vh] bg-gradient-to-br from-slate-50 via-white to-emerald-50 py-20" aria-label="Product hero">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-2">

            <div class="space-y-8 md:pr-6">
                <h1 class="text-4xl font-bold leading-[1.05] text-accent sm:text-5xl"><?php echo esc_html($hero['title']); ?></h1>
                <div class="aspect-square w-full max-w-[380px] overflow-hidden rounded-3xl border-2 border-secondary bg-white p-4 shadow-lg">
                    <img class="block h-full w-full object-contain"
                         src="<?php echo esc_url($hero['image_url']); ?>"
                         alt="<?php echo esc_attr($hero['image_alt']); ?>"
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