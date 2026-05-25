<?php
$banner_title  = get_sub_field('recent_banner_title');
$banner_amount = get_sub_field('recent_banner_amount');
$banner_type   = get_sub_field('recent_banner_type') ?: 'publication';
$banner_bg = get_sub_field('recent_banner_img');

$banner_posts = new WP_Query([
  'post_type'      => $banner_type,
  'post_status'    => 'publish',
  'posts_per_page' => $banner_amount,
  'orderby'        => 'date',
  'order'          => 'DESC',
]);
?>

<?php if ($banner_posts->have_posts()) : ?>
  <section class="px-5">
    <div class="container mx-auto py-10 xl:py-14">
      <?php if ($banner_title) : ?>
        <h2 class="mb-8">
          <?= esc_html($banner_title); ?>
        </h2>
      <?php endif; ?>

      <div class="swiper w-full h-[400px] bg-primary rounded-base">
        <?php if ($banner_type === 'publication' && $banner_bg): ?>
          <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= esc_url($banner_bg['url']); ?>');">
          </div>
          <div class="absolute inset-0 bg-black/40"></div>
        <?php endif; ?>
        <div class="swiper-wrapper">
          <?php while ($banner_posts->have_posts()) : $banner_posts->the_post(); ?>
            <?php
            $featured_image = get_the_post_thumbnail_url(
              get_the_ID(),
              'large'
            );
            ?>
            <div class="swiper-slide relative overflow-hidden rounded-base !w-full !h-full flex items-end <?php echo $banner_type === 'blog' ? 'bg-primary' : ''; ?>">
              <?php if ($banner_type === 'blog' && $featured_image) : ?>
                <div
                  class="absolute inset-0 bg-cover bg-center"
                  style="background-image: url('<?= esc_url($featured_image); ?>');">
                </div>
                <div class="absolute inset-0 bg-black/40"></div>
              <?php endif; ?>

              <a
                href="<?php the_permalink(); ?>"
                class="relative h-full w-full flex flex-col gap-2 justify-center items-center p-14 text-center text-white">
                <p class="px-2 py-1 rounded-full bg-white text-primary capitalize">
                  <?= esc_html($banner_type); ?>
                </p>

                <h2 class="font-bold mb-2 max-w-lg lg:max-w-3xl">
                  <?php the_title(); ?>
                </h2>

                <p>
                  <?php echo get_the_date(); ?>
                </p>
              </a>
            </div>
          <?php endwhile; ?>
        </div>
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
    </div>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>