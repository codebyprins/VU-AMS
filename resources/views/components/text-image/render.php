<?php
$title = $attributes['title'] ?? '';
$content  = $attributes['content'] ?? '';
$image = $attributes['image'] ?? '';
?>

<section class="py-10 px-20 bg-green-100">
    <div>
      <h2 class="text-2xl font-bold mb-4">
        <?php echo esc_html($title); ?> 
    </h2>

    <p class="mb-4">
        <?php echo esc_html($content); ?>
    </p>
    </div>
    <div>
        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-auto">
    </div>
</section>