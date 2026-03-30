<section class="py-20 bg-gray-100">
  <div class="relative max-w-4xl mx-auto text-center">

    <h1 class="text-4xl font-bold mb-4 text-red-500">
      <?php block_field('title'); ?>
    </h1>

    <p class="mb-6 text-lg">
      <?php block_field('text'); ?>
    </p>
    <figure class="absolute top-0 right-0">
      <img src="<?php block_field('image'); ?>"
        class="object-cover w-full h-full" alt="">
    </figure>
  </div>
</section>