<?php
$title = get_sub_field('title');
$content = get_sub_field('content');

$map_image = get_field('map_image', 'option');
$pin_color_input = get_field('pin_color', 'option') ?: 'primary';

$locations = get_posts([
    'post_type' => 'location',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
]);

$colors = [
    'red' => 'bg-cstm_red',
    'blue' => 'bg-primary',
    'green' => 'bg-cstm_green',
    'yellow' => 'bg-secondary',
    'black' => 'bg-cstm_black',
    'white' => 'bg-cstm_white',
];

if(isset($colors[$pin_color_input])) {
    $pin_color = $colors[$pin_color_input];
} else {
    $pin_color = 'primary';
}

var_dump($pin_color_input);
var_dump($pin_color);

?>
<section class="bg-[#F8F8F8] py-10">
    <div class="container mx-auto px-4">
        <div class="map_head flex flex-col items-center justify-center">
            <?php if ($title): ?>
                <h2 class="text-3xl font-bold mb-4">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($content): ?>
                <div class="mb-8 text-center">
                    <?php echo wp_kses_post($content); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="map_container xl:max-w-[1350px] lg:max-w-[1094px] md:max-w-[858px] sm:max-w-[710px] w-full mx-auto sm:px-4 px-7 py-10">
        <div class="map_inner relative w-full">
            <?php if ($map_image): ?>
                <img
                    src="<?php echo esc_url($map_image['url']); ?>"
                    alt="<?php echo esc_attr($map_image['alt']); ?>"
                    class="w-full h-auto"
                >
            <?php endif; ?>

            <?php foreach ($locations as $location): 
                $type = get_field('type', $location->ID);
                $position = get_field('map_position', $location->ID);
                $image = get_field('logo', $location->ID);

                $x = $position['x'] ?? 50;
                $y = $position['y'] ?? 50;
            ?>
                <div
                    class="map_item absolute -translate-x-1/2 -translate-y-1/2 <?php echo esc_attr($pin_color); ?> w-4 h-4 cursor-pointer rounded-full flex justify-center items-center"
                    style="left: <?php echo esc_attr($x); ?>%; top: <?php echo esc_attr($y); ?>%;"
                    data-location-id="<?php echo esc_attr($location->ID); ?>"
                >
                    <div class="map_item-inner <?php echo esc_attr($pin_color); ?> rounded-full w-3 h-3"></div>
                    <div
                        id="map_info_<?php echo esc_attr($location->ID); ?>"
                        class="map_information z-[1] absolute bottom-[25px] left-1/2 -translate-x-1/2 bg-white sm:px-6 px-4 sm:py-4 py-2 rounded-xl shadow-lg cursor-auto opacity-0 pointer-events-none transition-opacity duration-300"
                    >
                        <?php if ($location->post_title): ?>
                            <h4 class="font-bold text-[#00B2FF] whitespace-nowrap">
                                <?php echo esc_html($location->post_title); ?>
                            </h4>
                        <?php endif; ?>

                        <?php if ($type): ?>
                            <p class="font-semibold text-black whitespace-nowrap">
                                <?php echo esc_html($type); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($image): ?>
                            <img
                                src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt']); ?>"
                                class="mt-2 max-w-[250px] max-h-[150px] object-cover"
                            >
                        <?php endif; ?>

                        <svg
                            class="absolute top-full left-1/2 -translate-x-1/2"
                            width="20"
                            height="10"
                            viewBox="0 0 20 10"
                            fill="none"
                        >
                            <polygon points="0,0 10,10 20,0" fill="white"/>
                        </svg>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>