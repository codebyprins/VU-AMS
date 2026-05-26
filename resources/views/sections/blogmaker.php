<?php if( have_rows('post_blocks') ): ?>
  <?php while( have_rows('post_blocks') ): the_row(); ?>

    <?php if( get_row_layout() == 'text_block_group' ): ?>
      <div class="block block--text">
        <?php the_sub_field('content'); ?>
      </div>

    <?php elseif( get_row_layout() == 'cta_block' ): ?>
      <div class="block block--cta">
        <h3><?php the_sub_field('heading'); ?></h3>
        <p><?php the_sub_field('text'); ?></p>
        <a href="<?php the_sub_field('button_url'); ?>" class="btn">
          <?php the_sub_field('button_label'); ?>
        </a>
      </div>

    <?php elseif( get_row_layout() == 'iframe_block' ): ?>
      <div class="block block--iframe">
        <iframe src="<?php the_sub_field('url'); ?>" 
                width="100%" 
                height="<?php the_sub_field('height'); ?>" 
                frameborder="0" 
                allowfullscreen>
        </iframe>
      </div>

    <?php elseif( get_row_layout() == 'text_image_block' ): ?>
      <div class="block block--text-image">
        <div class="block__text">
          <?php the_sub_field('content'); ?>
        </div>
        <div class="block__image">
          <?php $img = get_sub_field('image'); if( $img ): ?>
            <img src="<?= esc_url($img['url']); ?>" alt="<?= esc_attr($img['alt']); ?>">
          <?php endif; ?>
        </div>
      </div>

    <?php endif; ?>

  <?php endwhile; ?>
<?php endif; ?>