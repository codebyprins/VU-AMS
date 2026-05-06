<?php
$prc_section_title = get_sub_field('product_cards_section_title');
$prc_card_layout   = get_sub_field('product_card_layout');
$prc_cards         = get_sub_field('product_cards');
?>

<?php if ($prc_cards): ?>
  <section class="px-5">
    <div class="container mx-auto py-10 xl:py-14">

      <?php if (!empty($prc_section_title)): ?>
        <h2 class="pb-8">
          <?php echo esc_html($prc_section_title); ?>
        </h2>
      <?php endif; ?>

      <div class="flex flex-col md:flex-row gap-4">

        <?php foreach ($prc_cards as $prc_card): ?>

          <?php
          $product = $prc_card['product_card_product'] ?? null;

          if (is_numeric($product)) {
            $product = get_post($product);
          }

          if (!($product instanceof WP_Post)) {
            continue;
          }

          $product_id = $product->ID;
          $info       = get_field('product_general_info', $product_id) ?: [];

          $image       = $info['product_card_image'] ?? null;
          $description = $info['product_card_description'] ?? '';
          $specs       = $info['product_card_specifications'] ?? [];

          $is_vertical = ($prc_card_layout === 'Image text vertical');
          ?>

          <div class="border border-black rounded-base p-10 w-full md:w-1/2 flex flex-col">

            <div class="<?php echo $is_vertical ? 'flex flex-col gap-6 flex-1' : 'flex flex-col lg:flex-row gap-4 flex-1'; ?>">

              <?php if (!empty($image['url'])): ?>
                <figure class="<?php echo $is_vertical ? 'h-[250px] w-full' : 'h-[350px] w-full lg:w-1/2'; ?> overflow-hidden shrink-0">
                  <img
                    class="w-full h-full object-cover block"
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
                  >
                </figure>
              <?php endif; ?>

              <div class="<?php echo $is_vertical ? 'w-full' : 'w-full lg:w-1/2'; ?> flex flex-col justify-center gap-4">

                <?php if (!empty($description)): ?>
                  <p>
                    <?php echo esc_html($description); ?>
                  </p>
                <?php endif; ?>

                <?php if (!empty($specs)): ?>
                  <ul class="hidden sm:block list-none space-y-1">

                    <?php foreach ($specs as $spec): ?>
                      <?php
                      $type    = $spec['specification_type'] ?? '';
                      $content = $spec['specification_content'] ?? '';
                      ?>

                      <?php if ($type && $content): ?>
                        <li class="flex gap-1 flex-wrap">
                          <span><?php echo esc_html($type); ?>:</span>
                          <span><?php echo esc_html($content); ?></span>
                        </li>
                      <?php endif; ?>

                    <?php endforeach; ?>

                  </ul>
                <?php endif; ?>

              </div>
            </div>

            <div class="flex gap-4 justify-between mt-6">

              <div>
                <p class="text-lg">Go to</p>
                <h3>
                  <?php echo esc_html(get_the_title($product_id)); ?>
                </h3>
              </div>

              <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M12.6 12L8.7 8.1q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.6 4.6q.15.15.213.325t.062.375t-.062.375t-.213.325l-4.6 4.6q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7z" />
                </svg>
              </div>

            </div>

          </div>

        <?php endforeach; ?>

      </div>

    </div>
  </section>
<?php endif; ?>