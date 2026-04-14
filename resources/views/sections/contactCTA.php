<?php
$title = get_sub_field('title_contactCTA') ?: 'Neem contact op';
$text = get_sub_field('text_contactCTA') ?: 'Heb je vragen?';
$button_text = get_sub_field('button_text_contactCTA') ?: 'Neem contact op';
$button_url = get_sub_field('button_url_contactCTA') ?: '#';
$image = get_sub_field('image_contactCTA');

$image_url = is_array($image) && !empty($image['url'])
    ? $image['url']
    : get_template_directory_uri() . '/resources/images/contact-default.jpg';

$image_alt = is_array($image) && !empty($image['alt'])
    ? $image['alt']
    : 'Contact image';
?>

<section class="py-20" aria-label="Contact">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-10 rounded-3xl bg-white p-6 shadow-lg ring-1 ring-slate-200/70 sm:p-8 md:grid-cols-12">
            <div class="md:col-span-5">
                <div class="aspect-square w-full max-w-[340px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                    <img
                        class="block h-full w-full object-cover"
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr($image_alt); ?>"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
            </div>

            <div class="space-y-6 md:col-span-7">
                <h2 class="text-3xl font-bold leading-tight text-accent sm:text-4xl"><?php echo esc_html($title); ?></h2>
                <p class="text-base leading-relaxed text-slate-600"><?php echo esc_html($text); ?></p>
                <a
                    class="btn btn-primary-outline inline-flex items-center border-secondary text-secondary transition hover:bg-secondary hover:text-white"
                    href="<?php echo esc_url($button_url); ?>"
                >
                    <?php echo esc_html($button_text); ?>
                </a>
            </div>
        </div>
    </div>
</section>