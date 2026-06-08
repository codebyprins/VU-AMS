<?php

$padding_top = get_sub_field('padding_top');
$numerical_items = get_sub_field('numerical_items');

?>

<section class="bg-[#F8F8F8] pb-14 <?php echo $padding_top ? 'pt-5' : 'pt-14'; ?>">
    <div class="container mx-auto px-4 flex md:flex-row flex-col md:gap-20 gap-5 items-center justify-center">
        <?php foreach ($numerical_items as $item) : ?>
            <?php
            $display_number = $item['number'];
            $sync_count = $item['sync_count'];
            
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
            <div class="number-item min-w-[100px] flex flex-col items-center gap-1 md:mb-8 mb-4">
                <img class="w-14 h-14 object-contain" src="<?php echo esc_url($item['icon']['url']); ?>" alt="icon">
                <div class="number flex flex-row items-end justify-center">
                    <img class="w-7 h-7 mb-[3.5px]" src="/wp-content/themes/VU-AMS/resources/images/icons/Add_Plus.svg" alt="">
                    <span class="counter font-bold text-4xl mr-[25px]" data-target="<?php echo $display_number; ?>">0</span>
                </div>
                <div class="line bg-[#00B2FF] h-[1px] w-[30px]"></div>
                <span class="type font-semibold text-xl"><?php echo esc_html($item['text']); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>