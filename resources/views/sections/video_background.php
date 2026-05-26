<?php
$video  = get_sub_field('video_file');
$title  = get_sub_field('title');
$text   = get_sub_field('text_field');
$layout = get_sub_field('layout_button') ?: 'center';

if (!$video && empty($title) && empty($text)) {
    return;
}

$alignment_classes = [
    'left'   => 'items-start text-left',
    'center' => 'items-center text-center',
    'right'  => 'items-end text-right',
];

$align = $alignment_classes[$layout] ?? $alignment_classes['center'];
?>

<style>
    .hero-title p {
        font-size: inherit;
        font-weight: inherit;
        line-height: inherit;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .fade-in-up.delay-1 { animation-delay: 0.1s; }
    .fade-in-up.delay-2 { animation-delay: 0.25s; }
</style>

<section class="relative w-screen h-[400px] overflow-hidden">

    <?php if ($video): ?>
        <video autoplay muted loop playsinline
            class="absolute inset-0 w-full h-full object-cover z-10">
            <source src="<?php echo esc_url($video); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <?php if ($title || $text): ?>
        <div class="relative z-20 h-full flex flex-col justify-end p-10 text-white bg-gradient-to-t from-black/60 to-transparent <?php echo $align; ?>">

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