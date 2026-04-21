<?php

$title = get_sub_field('title');
$content = get_sub_field('content');

$locations = get_posts([
    'post_type' => 'location',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
]);

?>

<section class="bg-[#F8F8F8] py-10">
    <div class="container mx-auto px-4">
        <div class="map_head flex justify-center items-center flex-col">
            <h2 class="text-3xl font-bold mb-4"><?php echo $title; ?></h2>
            <div class="mb-8 text-center"><?php echo $content; ?></div>
        </div>
    </div>
    <div class="map_container xl:max-w-[1350px] lg:max-w-[1094px] md:max-w-[858px] sm:max-w-[710px] w-full h-full mx-auto sm:px-4 px-7 py-10">
        <div class="map_inner flex justify-center items-center w-full h-full relative">
            <img src="./wp-content/themes/VU-AMS/resources/images/map.png" class="opacity-50" alt="World Map">
            <?php foreach ($locations as $location) : 
                $type = get_field('type', $location->ID);
                $position = get_field('position', $location->ID);
                
                $left_or_right = $position['leftright']['left_or_right'] ?? false;
                $left = $position['leftright']['left'] ?? 0;
                $right = $position['leftright']['right'] ?? 0;
                $top_or_bottom = $position['topbottom']['top_or_bottom'] ?? false;
                $top = $position['topbottom']['top'] ?? 0;
                $bottom = $position['topbottom']['bottom'] ?? 0;
                
                $position_style = '';
                $position_style .= $left_or_right ? "left: {$left}%;" : "right: {$right}%;";
                $position_style .= ' ';
                $position_style .= $top_or_bottom ? "top: {$top}%;" : "bottom: {$bottom}%;";
            ?>
            <div id="map_item_open" class="map_item absolute bg-[#00b3ff6c] sm:w-6 w-4 sm:h-6 h-4 cursor-pointer rounded-full flex justify-center items-center" style="<?php echo $position_style; ?>" data-location-id="<?php echo $location->ID; ?>">
                <div class="map_item-inner bg-[#00B2FF] rounded-full sm:w-5 w-3 sm:h-5 h-3"></div>
                <div id="map_info_<?php echo $location->ID; ?>" class="map_information absolute bottom-[25px] left-1/2 transform -translate-x-1/2 bg-white sm:px-6 px-4 sm:py-4 py-2 rounded-xl shadow-lg cursor-auto opacity-0 pointer-events-none transition-opacity duration-300">
                    <h4 class="font-bold text-[#00B2FF] whitespace-nowrap"><?php echo $location->post_title; ?></h4>
                    <p class="font-semibold text-black whitespace-nowrap"><?php echo $type; ?></p>
                    <svg class="absolute top-full left-1/2 transform -translate-x-1/2" width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="0,0 10,10 20,0" fill="white" />
                    </svg>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>