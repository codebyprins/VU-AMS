<?php
$title = $attributes['title'] ?? '';
$text  = $attributes['text'] ?? '';
$image = $attributes['image'] ?? '';
?>

<section class="py-24 bg-gray-100">
    <div class="max-w-6xl mx-auto text-center px-6">

        <?php if ($title): ?>
            <h1 class="text-5xl font-bold mb-6">
                <?php echo esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($text): ?>
            <p class="text-lg text-gray-600 mb-10">
                <?php echo esc_html($text); ?>
            </p>
        <?php endif; ?>

        <?php if ($image): ?>
            <img src="<?php echo esc_url($image); ?>" class="mx-auto rounded-xl shadow-lg" />
        <?php endif; ?>

    </div>
</section>