<?php
/**
 * Template part: Contact CTA
 * ACF (optional): contact_title, contact_text, contact_button, contact_button_url, contact_image
 */

$f   = fn($k) => function_exists('get_field') ? get_field($k) : null;
$img = $f('contact_image');

$contact = wp_parse_args($args ?? [], [
    'title'      => $f('contact_title')      ?: 'Lorem ipsum dolor sit amet',
    'text'       => $f('contact_text')       ?: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'button'     => $f('contact_button')     ?: 'Get in contact',
    'button_url' => $f('contact_button_url') ?: '#',
    'image_url'  => $img['url'] ?? get_template_directory_uri() . '/resources/images/contact-default.jpg',
    'image_alt'  => $img['alt'] ?? 'Contact image',
]);

$external = preg_match('#^https?://#i', $contact['button_url'])
    && (!function_exists('home_url') || strpos($contact['button_url'], home_url()) !== 0);
?>

<section class="py-20" aria-label="Contact">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-10 rounded-3xl bg-white p-6 shadow-lg ring-1 ring-slate-200/70 sm:p-8 md:grid-cols-12">

            <div class="md:col-span-5">
                <div class="aspect-square w-full max-w-[340px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                    <img class="block h-full w-full object-cover"
                         src="<?php echo esc_url($contact['image_url']); ?>"
                         alt="<?php echo esc_attr($contact['image_alt']); ?>"
                         loading="lazy" decoding="async">
                </div>
            </div>

            <div class="space-y-6 md:col-span-7">
                <h2 class="text-3xl font-bold leading-tight text-accent sm:text-4xl"><?php echo esc_html($contact['title']); ?></h2>
                <p class="text-base leading-relaxed text-slate-600"><?php echo esc_html($contact['text']); ?></p>
                <a class="btn btn-primary-outline inline-flex items-center border-secondary text-secondary transition hover:bg-secondary hover:text-white"
                   href="<?php echo esc_url($contact['button_url']); ?>"
                   <?php echo $external ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                    <?php echo esc_html($contact['button']); ?>
                </a>
            </div>

        </div>
    </div>
</section>