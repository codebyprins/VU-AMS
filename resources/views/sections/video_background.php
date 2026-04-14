<?php
$video = get_sub_field('video_file');
$title = get_sub_field('title');
$text  = get_sub_field('text_field');
?>

<section class="relative w-screen h-screen overflow-hidden">

    <?php if ($video): ?>
        <video autoplay muted loop playsinline
            class="absolute inset-0 w-full h-full object-cover z-10">
            <source src="<?php echo esc_url($video); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <div class="relative z-20 h-full flex flex-col justify-end p-10 text-white bg-gradient-to-t from-black/60 to-transparent">

        <?php if ($title): ?>
            <h1 class="text-4xl md:text-6xl font-bold">
                <?php echo wp_kses_post($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($text): ?>
            <div class="mt-4 text-base md:text-lg leading-relaxed">
                <?php echo apply_filters('the_content', $text); ?>
            </div>
        <?php endif; ?>

    </div>

</section>