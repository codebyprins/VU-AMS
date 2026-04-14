<?php
$prc_section_title = get_sub_field('product_cards_section_title');
$prc_card_layout   = get_sub_field('product_card_layout');
//get selected products for cards
$prc_cards         = get_sub_field('product_cards');
?>

<?php if ($prc_cards): ?>
  <section class="px-5">
    <div class="container mx-auto py-10 xl:py-14">

      <?php if (!empty($prc_section_title)) : ?>
        <h2 class="mb-8">
          <?php echo esc_html($prc_section_title); ?>
        </h2>
      <?php endif; ?>

      <?php if (!empty($prc_cards) && is_array($prc_cards)) : ?>
        <div class="grid grid-cols-12 gap-4">

          <?php foreach ($prc_cards as $card) : ?>

            <?php
            // Get product from custom postype
            $product = $card['product_card_product'] ?? null;

            if (is_numeric($product)) {
              $product = get_post($product);
            }

            if (!($product instanceof WP_Post)) {
              continue;
            }

            $product_id = $product->ID;

            // Info from custom post type product
            $info = get_field('product_general_info', $product_id) ?: [];

            $image       = $info['product_card_image'] ?? null;
            $description = $info['product_card_description'] ?? '';

            // layout
            $is_horizontal = ($prc_card_layout === 'Image text horizontal');

            $has_image = !empty($image['url']);
            $has_text  = !empty($description);

            $is_image_only = $has_image && !$has_text;
            $is_text_only  = $has_text && !$has_image;
            ?>

            <a href="<?php echo esc_url(get_permalink($product_id)); ?>"
              class="col-span-12 xl:col-span-6 flex flex-col justify-between
                    border border-black rounded-base
                    p-5 md:p-10
                    hover:bg-surface hover:-translate-y-1
                    transition duration-300 ease-in-out">


              <div class="<?php echo esc_attr($is_horizontal ? 'flex flex-row' : 'flex flex-col'); ?> justify-center items- center gap-4 mb-8">


                <?php if ($has_image) : ?>
                  <figure class="<?php
                                  echo esc_attr(
                                    $is_image_only
                                      ? 'w-full'
                                      : ($is_horizontal ? 'w-1/3' : 'w-full')
                                  );
                                  ?> max-h-[300px] overflow-hidden">

                    <img
                      src="<?php echo esc_url($image['url']); ?>"
                      alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
                      class="w-full h-full object-cover rounded-base">

                  </figure>
                <?php endif; ?>


                <?php if ($has_text) : ?>
                  <div class="<?php
                              echo esc_attr(
                                $is_text_only
                                  ? 'w-full'
                                  : ($is_horizontal ? 'w-2/3' : 'w-full mt-4')
                              );
                              ?> flex items-center">

                    <p><?php echo esc_html($description); ?></p>

                  </div>
                <?php endif; ?>

              </div>


              <div>
                <p class="mb-2">Go to</p>

                <div class="flex justify-between items-center gap-4">
                  <h3 class="text-lg font-medium">
                    <?php echo esc_html(get_the_title($product_id)); ?>
                  </h3>

                  <svg xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M12.6 12L8.7 8.1q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.6 4.6q.15.15.213.325t.062.375t-.062.375t-.213.325l-4.6 4.6q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7z" />
                  </svg>
                </div>
              </div>

            </a>

          <?php endforeach; ?>

        </div>
      <?php endif; ?>

    </div>
  </section>

<?php endif; ?>