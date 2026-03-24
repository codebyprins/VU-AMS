<?php
$title = $attributes['title'] ?? '';
$subtitle = $attributes['subtitle'] ?? '';
$images = $attributes['images'] ?? [];
?>


<section class="py-10 px-20 bg-blue-100">
  <div>
      <h2><?php echo esc_html($title); ?></h2>
      <h3><?php echo esc_html($subtitle); ?></h3>
  </div>
  <div>
    <ul>
      <?php foreach ($images as $image): ?>
        <li>
          <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-auto">
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>