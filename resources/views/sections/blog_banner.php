<?php
$banner_title  = get_sub_field('blog_banner_title');
$banner_amount = get_sub_field('blog_banner_amount');

$blog_posts = new WP_Query([
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => $banner_amount,
  'orderby'        => 'date',
  'order'          => 'DESC',
]);
?>

<section class="px-5">
  <div class="container mx-auto py-10 xl:py-14">

    <?php if ($banner_title): ?>
      <h2 class="mb-8"><?php echo esc_html($banner_title); ?></h2>
    <?php endif; ?>

    <?php if ($blog_posts->have_posts()) : ?>
      <div class="swiper w-full h-[400px]">
        <div class="swiper-wrapper">
          <?php 
          $slide_count = 0;
          while ($blog_posts->have_posts()) : $blog_posts->the_post();
            $slide_count++;
            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $featured_image = $featured_image ?: '';
          ?>
            <div class="swiper-slide bg-primary relative overflow-hidden rounded-lg !w-full !h-full flex items-end">
              <!-- Background Image -->
              <div
                class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('<?php echo esc_url($featured_image); ?>');">
              </div>

              <!-- overlay -->
              <?php if (has_post_thumbnail()): ?>
                <div class="absolute inset-0 bg-black/40"></div>
              <?php endif; ?>

              <!-- Content -->
              <a href="<?php the_permalink(); ?>" class="relative h-full w-full flex flex-col justify-center items-center p-6 text-center text-white">
                <h2 class="font-bold mb-2"><?php the_title(); ?></h2>
                <p class="text-sm"><?php echo get_the_date(); ?></p>
              </a>
            </div>
          <?php endwhile; ?>
        </div>

        <!-- Navigation -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next hidden sm:block text-white after:text-2xl w-10 h-10 bg-secondary rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="currentColor" d="M12.6 12L8.7 8.1q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.6 4.6q.15.15.213.325t.062.375t-.062.375t-.213.325l-4.6 4.6q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7z" />
          </svg>
        </div>
        <div class="swiper-button-prev hidden sm:block text-white after:text-2xl w-10 h-10 bg-secondary rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="currentColor" d="m10.8 12l3.9 3.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-4.6-4.6q-.15-.15-.212-.325T8.425 12t.063-.375t.212-.325l4.6-4.6q.275-.275.7-.275t.7.275t.275.7t-.275.7z" />
          </svg>
        </div>
      </div>

    <?php else : ?>
      <p>No posts found.</p>
    <?php endif; ?>

  </div>
</section>