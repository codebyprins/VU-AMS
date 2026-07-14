<?php
$video  = get_sub_field('video_file');
$title  = get_sub_field('title');
$text   = get_sub_field('text_field');
$layout = get_sub_field('text_alignment') ?: 'top';
$video_height = get_sub_field('video_height') ?: '400px';

if (!$video && empty($title) && empty($text)) {
    return;
}

$alignment_classes = [
    'top'   => 'items-center justify-start text-center',
    'mid' => 'items-center justify-center text-center',
    'bottom'  => 'items-center justify-end text-center',
];

$height_classes = [
    '400px' => 'h-[400px]',
    '500px' => 'h-[500px]',
    '650px' => 'h-[650px]',
];


$align = $alignment_classes[$layout] ?? $alignment_classes['top'];
$height = $height_classes[$video_height] ?? $height_classes['400px'];
?>

<section class="relative <?php echo $height; ?> overflow-hidden">
    <?php if ($video): ?>
        <video autoplay muted loop playsinline
            class="absolute inset-0 w-full h-full object-cover z-10">
            <source src="<?php echo esc_url($video); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <?php if ($title || $text): ?>
        <div class="relative z-20 h-full flex flex-col p-10 text-white bg-gradient-to-t from-black/60 to-transparent <?php echo $align; ?>">

            <?php if ($title): ?>
                <h1 class="hero-title text-5xl md:text-7xl font-bold fade-in-up delay-1">
                    <?php echo wp_kses_post($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <div class="leading-[1.2] hero-text mt-4 text-1xl text-[1.875rem] max-w-[600px] fade-in-up delay-2">
                    <?php echo apply_filters('the_content', $text); ?>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</section>