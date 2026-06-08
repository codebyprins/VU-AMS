<?php
$bigsmall = get_sub_field('bigsmall');
$big = get_sub_field('big');
$small = get_sub_field('small');
?>

<section class="bg-[#F8F8F8] w-full h-full">
  <?php if ($bigsmall) : ?>

    <div class="container mx-auto relative flex flex-col md:flex-row items-center w-full"
      style="min-height: 491px;">

      <div class="w-full md:w-1/2 flex-shrink-0 px-6 pt-8 pb-6 md:pl-[20px] md:pt-[89px] md:pb-[91px] md:pr-8">

        <?php if ($big['subtitle']) : ?>
          <p class="font-sans text-[16px] md:text-[24px] text-black mb-2 animate-fade-in-up delay-1">
            <?php echo esc_html($big['subtitle']); ?>
          </p>
        <?php endif; ?>

        <?php if ($big['title']) : ?>
          <h1 class="font-sans text-[32px] md:text-[48px] font-bold leading-tight text-black mb-4 animate-fade-in-up delay-2">
            <?php echo esc_html($big['title']); ?>
          </h1>
        <?php endif; ?>

        <?php if ($big['content']) : ?>
          <div class="font-sans text-[14px] md:text-[16px] text-black mb-6 animate-fade-in-up delay-3">
            <?php echo $big['content']; ?>
          </div>
        <?php endif; ?>

        <?php if ($big['button']) : ?>
          <a href="<?php echo esc_url($big['button']['url']); ?>"
            class="inline-block bg-primary text-white font-sans text-[16px] px-6 py-3 rounded-lg animate-fade-in-up delay-4">
            <?php echo esc_html($big['button']['title']); ?>
          </a>
        <?php endif; ?>

      </div>

      <?php if ($big['image_or_bubbles'] && $big['image']) : ?>
        <div class="w-full md:flex-1 flex items-center justify-center px-8 pb-8 pt-4 md:p-12">
          <img class="max-h-[220px] md:max-h-[350px] w-auto object-contain"
            src="<?php echo esc_url($big['image']['url']); ?>"
            alt="<?php echo esc_html($big['image']['alt']); ?>">
        </div>
      <?php elseif (!$big['image_or_bubbles'] && $big['bubbles']) : ?>
        <div class="w-full md:flex-1 flex items-center justify-center px-8 md:pb-8 pb-20 md:pt-4 pt-7 md:p-12">
          <div class="bubble_container relative flex flex-row gap-5 sm:mr-[80px] mr-0">
            <?php foreach ($big['bubbles'] as $index => $bubble) : ?>
              <?php
              if (!is_array($bubble)) {
                continue;
              }
              $is_top = ((int)$index === 1);
              
              $display_number = $bubble['number'];
              $sync_count = $bubble['sync_count'];
              
              if ($sync_count && $sync_count !== 'no_sync') {
                $post_type_map = [
                  'locations' => 'location',
                  'publications' => 'publication',
                  'team_members' => 'team-member',
                  'projects' => 'project',
                  'products' => 'product',
                  'software_releases' => 'software-release'
                ];
                
                if (isset($post_type_map[$sync_count])) {
                  $posts = get_posts([
                    'post_type' => $post_type_map[$sync_count],
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'fields' => 'ids'
                  ]);
                  $display_number = count($posts);
                }
              }
              ?>
              <div class="relative flex flex-col justify-center items-center gap-4 <?php echo $is_top ? 'pb-[100px]' : 'pt-[100px]'; ?>">
                <?php if ($is_top && $bubble['text']) : ?>
                  <p class="absolute top-[-45px] text-2xl md:text-3xl"><?php echo esc_html($bubble['text']); ?></p>
                <?php endif; ?>
                <div class="rounded-full bg-primary min-w-[85px] min-h-[85px] flex items-center justify-center w-fit">
                  <?php if ($display_number) : ?>
                    <p class="text-2xl text-white"><?php echo esc_html($display_number); ?></p>
                  <?php endif; ?>
                </div>
                <?php if (!$is_top && $bubble['text']) : ?>
                  <p class="absolute bottom-[-45px] text-2xl md:text-3xl"><?php echo esc_html($bubble['text']); ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php elseif ($big['image']) : ?>
        <div class="w-full md:flex-1 flex items-center justify-center px-8 pb-8 pt-4 md:p-12">
          <img class="max-h-[220px] md:max-h-[350px] w-auto object-contain"
            src="<?php echo esc_url($big['image']['url']); ?>"
            alt="<?php echo esc_html($big['image']['alt']); ?>">
        </div>
      <?php endif; ?>

    </div>

  <?php else : ?>

    <div class="container mx-auto relative flex items-center w-full">

      <div class="px-6 py-8 md:pt-[89px] md:pb-[91px]">

        <?php if ($small['subtitle']) : ?>
          <p class="font-sans text-[16px] md:text-[24px] text-black mb-2 animate-fade-in-up delay-1">
            <?php echo esc_html($small['subtitle']); ?>
          </p>
        <?php endif; ?>

        <?php if ($small['title']) : ?>
          <h1 class="font-sans text-[28px] md:text-[48px] font-bold leading-tight text-black animate-fade-in-up delay-2">
            <?php echo esc_html($small['title']); ?>
          </h1>
        <?php endif; ?>

      </div>

    </div>

  <?php endif; ?>

</section>