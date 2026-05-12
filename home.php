<?php get_header(); ?>

<main>
  <h1>Blog</h1>

  <?php if( have_posts() ): ?>
    <?php while( have_posts() ): the_post(); ?>

      <article>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php echo get_the_date(); ?></p>
        <p><?php the_excerpt(); ?></p>
      </article>

    <?php endwhile; ?>

    <?php the_posts_pagination(); ?>

  <?php else: ?>
    <p>No posts found.</p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>