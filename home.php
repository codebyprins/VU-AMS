<?php get_header(); ?>

<?php
$blog_eyebrow = get_field('blog_eyebrow', 'option') ?: 'Blog';
$blog_heading = get_field('blog_heading', 'option') ?: 'Latest articles &amp; updates';
$blog_intro   = get_field('blog_intro', 'option') ?: get_bloginfo('description');
?>

<section class="border-b border-slate-200 bg-white">
  <div class="container mx-auto px-4 py-12 lg:py-16">
    <div class="max-w-2xl">
      <span class="inline-block text-sm font-semibold uppercase tracking-[0.2em] text-primary">
        <?php echo esc_html($blog_eyebrow); ?>
      </span>
      <h1 class="mt-3 text-h2 sm:text-h1 font-bold leading-tight text-accent">
        <?php echo wp_kses_post($blog_heading); ?>
      </h1>
      <?php if ($blog_intro) : ?>
        <p class="mt-4 text-lg text-slate-600"><?php echo esc_html($blog_intro); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="bg-white">
  <div class="container mx-auto px-4 py-12 lg:py-16">

    <?php if (have_posts()) : ?>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">

        <?php while (have_posts()) : the_post(); ?>

          <?php
          $post_id   = get_the_ID();
          $permalink = get_permalink();

          // Build an excerpt: prefer the native excerpt, otherwise grab text from the
          // ACF "post_blocks" flexible content used by this theme's single posts.
          $excerpt = has_excerpt() ? get_the_excerpt() : '';
          if (!$excerpt && have_rows('post_blocks', $post_id)) {
              while (have_rows('post_blocks', $post_id)) {
                  the_row();
                  if (in_array(get_row_layout(), ['text_block_group', 'text_block', 'text_image_block'], true)) {
                      $excerpt = wp_strip_all_tags((string) get_sub_field('content'));
                      if ($excerpt) {
                          break;
                      }
                  }
              }
          }
          $excerpt = $excerpt ? wp_trim_words($excerpt, 22, '&hellip;') : '';

          $categories = get_the_category();
          ?>

          <article class="group flex flex-col overflow-hidden rounded-base border border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-primary hover:shadow-lg">

            <a href="<?php echo esc_url($permalink); ?>" class="block aspect-[16/10] overflow-hidden bg-[#F8F8F8]" aria-hidden="true" tabindex="-1">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', [
                    'class'   => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105',
                    'alt'     => esc_attr(get_the_title()),
                    'loading' => 'lazy',
                ]); ?>
              <?php else : ?>
                <span class="flex h-full w-full items-center justify-center bg-primary-gradient text-white/90">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                  </svg>
                </span>
              <?php endif; ?>
            </a>

            <div class="flex flex-1 flex-col gap-3 p-6">

              <?php if (!empty($categories)) : ?>
                <div class="flex flex-wrap gap-2">
                  <?php foreach (array_slice($categories, 0, 2) as $cat) : ?>
                    <a href="<?php echo esc_url(get_category_link($cat)); ?>"
                       class="rounded-full bg-secondary/20 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-accent transition-colors hover:bg-secondary/40">
                      <?php echo esc_html($cat->name); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <h2 class="text-h5 font-bold leading-snug text-accent">
                <a href="<?php echo esc_url($permalink); ?>" class="transition-colors hover:text-primary">
                  <?php the_title(); ?>
                </a>
              </h2>

              <?php if ($excerpt) : ?>
                <p class="text-sm leading-relaxed text-slate-600"><?php echo esc_html($excerpt); ?></p>
              <?php endif; ?>

              <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"
                      class="text-xs font-medium uppercase tracking-wide text-slate-400">
                  <?php echo esc_html(get_the_date()); ?>
                </time>
                <a href="<?php echo esc_url($permalink); ?>"
                   class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition-colors hover:text-primary_dark">
                  Read more
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                  </svg>
                </a>
              </div>

            </div>

          </article>

        <?php endwhile; ?>

      </div>

      <?php
      if (function_exists('custom_pagination')) {
          custom_pagination($GLOBALS['wp_query']);
      } else {
          the_posts_pagination();
      }
      ?>

    <?php else : ?>

      <div class="rounded-base bg-[#F8F8F8] p-12 text-center">
        <h2 class="text-h4 font-bold text-accent">No posts found</h2>
        <p class="mx-auto mt-3 max-w-md text-slate-600">
          There are no articles published yet. Please check back later.
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary mx-auto mt-6">Back to home</a>
      </div>

    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
