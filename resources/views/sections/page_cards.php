<?php
$pc_section_title = get_sub_field('page_card_section_title');
$pc_cards = get_sub_field('page_cards');
?>

<section class="px-5">
  <div class="container mx-auto py-10 xl:py-14 ">
    <h2 class="mb-8"><?php echo esc_html($pc_section_title); ?></h2>
    <div class="grid grid-cols-12 gap-4">
      <?php foreach ($pc_cards as $card): ?>
        <a href="<?php echo esc_url($card['page_card_link']); ?>"
          class="col-span-12 sm:col-span-6 xl:col-span-4 flex flex-col justify-end border-[1px] border-black rounded-base p-5 md:p-10 transform hover:bg-surface  hover:translate-y-[-5px] ease-in-out hover:duration-300">
          <p class="mb-2">Go to</p>
          <div class="flex justify-between items-center gap-4">
            <h3><?php echo esc_html($card['page_card_title']); ?></h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
              <path fill="currentColor" d="M12.6 12L8.7 8.1q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.6 4.6q.15.15.213.325t.062.375t-.062.375t-.213.325l-4.6 4.6q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7z" />
            </svg>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>