<section class="py-20 bg-gray-100">
  <div class="max-w-4xl mx-auto text-center flex gap-4">
    <div>
      <h1 class="text-4xl font-bold mb-4">
        <?php block_field('title'); ?>
      </h1>

      <p class="mb-6 text-lg">
        <?php block_field('text'); ?>
      </p>
    </div>

    <figure class="">
      <img src="<?php block_field('image'); ?>" alt="">
    </figure>

  </div>
</section>