<?php 
  $pc_section_title = get_sub_field('page_card_section_title');
  $pc_cards = get_sub_field('page_cards');
?>

<section class="px-5">
  <div class="container mx-auto py-10 xl:py-14 ">
    <h2 class="text-4xl"><?php echo esc_html($pc_section_title); ?></h2>
    <div class="grid grid-cols-12 gap-4">
      <?php foreach ($pc_cards as $card): ?>
        <a href="<?php echo esc_url($card['link']); ?>" class="bg-primary_light col-span-4 border-[1px] border-black rounded-base p-10">
          <div>
            <h3 class="text-2xl"><?php echo esc_html($card['title']); ?></h3>
            <!-- icon -->
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>