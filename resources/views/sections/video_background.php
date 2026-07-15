<?php
$background = get_sub_field('background_selection') ?: [];

$background_type = strtolower($background['style_option'] ?? '');

$video_file = $background['video_file'] ?? null;
$image_file = $background['image_file'] ?? null;

$title = get_sub_field('title');
$text = get_sub_field('text_field');
$title  = get_sub_field('title');
$text   = get_sub_field('text_field');
$layout = get_sub_field('text_alignment') ?: 'top';
$video_height = get_sub_field('video_height') ?: '400px';

if (empty($title) && empty($text)) {
    return;
}

$alignment_classes = [
    'top'   => 'items-center justify-start text-center',
    'mid' => 'items-center justify-center text-center',
    'bottom'  => 'items-center justify-end text-center',
];

$height_classes = [
    '400px' => 'h-[400px]',
    '500px' => 'h-[400px] sm:h-[500px]',
    '650px' => 'h-[400px] sm:h-[600px]',
];


$align = $alignment_classes[$layout] ?? $alignment_classes['top'];
$height = $height_classes[$video_height] ?? $height_classes['400px'];
?>

<section class="relative <?php echo $height; ?> overflow-hidden">
    <?php if ($background_type === 'video' && $video_file): ?>
        <video autoplay muted loop playsinline
            class="absolute inset-0 w-full h-full object-cover z-10">
            <source src="<?php echo esc_url($video_file); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <?php if ($background_type === 'image' && $image_file): ?>
        <img
            src="<?php echo esc_url($image_file['url']); ?>"
            alt="<?php echo esc_attr($image_file['alt'] ?? ''); ?>"
            class="absolute inset-0 w-full h-full object-cover z-10">
    <?php endif; ?>

    <?php if ($title || $text): ?>
        <div class="relative z-20 h-full flex flex-col p-10 text-white bg-gradient-to-t from-black/60 to-transparent <?php echo $align; ?>">

            <?php if ($title): ?>
                <h1 class="hero-title text-4xl md:text-6xl font-bold fade-in-up delay-1">
                    <?php echo wp_kses_post($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <div class="hero-text mt-4 max-w-3xl fade-in-up delay-2">
                    <?php echo apply_filters('the_content', $text); ?>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</section>