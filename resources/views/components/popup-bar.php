<?php
$show_popup = get_field('toggle_visibility', 'option');

if (! $show_popup) {
    return;
}

$first_link = get_field('first_link', 'option');
$second_link = get_field('second_link', 'option');
?>

<div id="popup" class="popup fixed inset-x-0 bottom-0 px-4 bg-[#ABE0E6] flex items-center justify-center z-50 w-full py-3 opacity-0 translate-y-4 transition-all duration-500 ease-out">
    <div class="container max-auto flex">
        <div class="w-[95%] flex items-start justify-between lg:flex-row flex-col gap-2">
            <a href="<?php echo esc_url($first_link['link']['url']); ?>" <?php echo !empty($first_link['link']['target']) ? ' target="' . esc_attr($first_link['link']['target']) . '" rel="noopener noreferrer"' : ''; ?> class="w-full flex flex-col gap-1">
                <div class="item-top flex items-center gap-3">
                    <div class="blue-bar w-20 h-5 rounded-full bg-[#01B4C9]"></div>
                    <h4><?php echo esc_html($first_link['title'] ?? ''); ?></h4>
                </div>
                <div class="item-bottom md:block hidden">
                    <?php echo wp_kses_post($first_link['content'] ?? ''); ?>
                </div>
            </a>
            <a href="<?php echo esc_url($second_link['link']['url']); ?>" <?php echo !empty($second_link['link']['target']) ? ' target="' . esc_attr($second_link['link']['target']) . '" rel="noopener noreferrer"' : ''; ?> class="w-full flex flex-col gap-1">
                <div class="item-top flex items-center gap-3">
                    <div class="blue-bar w-20 h-5 rounded-full bg-[#01B4C9]"></div>
                    <h4><?php echo esc_html($second_link['title'] ?? ''); ?></h4>
                </div>
                <div class="item-bottom md:block hidden pb-2">
                    <?php echo wp_kses_post($second_link['content'] ?? ''); ?>
                </div>
            </a>
        </div>
        <div class="w-[5%] flex items-center justify-center">
            <button class="cursor-pointer hover:opacity-50 transition-all min-w-8 min-h-8" onclick="closePopup()">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 24L16 16M16 16L8 8M16 16L24 8M16 16L8 24" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
</div>