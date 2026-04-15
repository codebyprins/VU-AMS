<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body class="min-h-screen flex flex-col">
    <?php wp_body_open(); ?>

    <?php
    $topbar_content = get_field('content', 'option');
    if ($topbar_content) : ?>
    <div class="hidden lg:block bg-[#ABE0E6] text-black text-xs py-3.5 overflow-hidden">
        <div id="topbar-marquee-wrap" class="flex">
            <span id="topbar-marquee-inner" class="whitespace-nowrap shrink-0"><?php
                $clean = wp_strip_all_tags($topbar_content);
                for ($i = 0; $i < 15; $i++) {
                    echo '<span class="px-12">' . esc_html($clean) . '</span>';
                }
            ?></span>
        </div>
    </div>
    <?php endif; ?>

    <header class="bg-gradient-to-r from-[#01B4C9] from-[62%] to-[#0F1733]">
        <div class="container mx-auto px-4 py-6 flex items-center gap-8">
            <?php
            $logo = get_field('logo', 'option');
            $logo_url = $logo ? esc_url($logo['url']) : esc_url(site_url('/wp-content/uploads/2026/04/image-1.png'));
            $logo_alt = $logo ? esc_attr($logo['alt']) : get_bloginfo('name');
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="shrink-0 flex items-center">
                <img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>" class="h-12 w-auto">
            </a>
            <nav class="hidden lg:flex flex-1 ml-8" role="navigation" aria-label="Hoofdmenu">
                <?php
                $chevron_url = esc_url(site_url('/wp-content/uploads/2026/04/glyphs_chevron-bold.png'));
                wp_nav_menu([
                    'theme_location' => 'primary_navigation',
                    'container'      => false,
                    'menu_class'     => 'flex items-center gap-6',
                    'item_spacing'   => 'preserve',
                    'walker'         => new class($chevron_url) extends Walker_Nav_Menu {
                        private string $chevron;
                        public function __construct(string $chevron_url) {
                            $this->chevron = $chevron_url;
                        }
                        public function start_lvl( &$output, $depth = 0, $args = null ) {
                            $output .= '<ul class="absolute left-0 top-full min-w-[200px] bg-white border border-[#F7C80C] rounded-[12px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 py-2">' . "\n";
                        }
                        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
                            $classes      = empty($item->classes) ? [] : (array) $item->classes;
                            $has_children = in_array('menu-item-has-children', $classes);
                            $is_active    = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);

                            if ($depth === 0) {
                                $li_class = $has_children ? 'relative group' : 'relative';
                                $weight   = $is_active ? 'font-extrabold' : 'font-medium';
                                $a_class  = "flex items-center gap-1 text-white text-sm $weight hover:text-[#F7C80C] transition-colors px-2 py-1";
                            } else {
                                $li_class = '';
                                $a_class  = 'block text-[#0F1733] text-sm px-5 py-2 hover:text-[#F7C80C] transition-colors';
                            }

                            $output .= "<li class=\"$li_class\">";

                            $href  = !empty($item->url) ? esc_url($item->url) : '#';
                            $title = apply_filters('the_title', $item->title, $item->ID);

                            $output .= "<a href=\"$href\" class=\"$a_class\">$title";

                            if ($has_children && $depth === 0) {
                                $output .= '<img src="' . $this->chevron . '" alt="" aria-hidden="true" class="h-3 w-3 brightness-0 invert rotate-180 transition-transform duration-200 group-hover:rotate-0">';
                            }

                            $output .= '</a>';
                        }
                        public function end_el( &$output, $item, $depth = 0, $args = null ) {
                            $output .= "</li>\n";
                        }
                    },
                ]);
                ?>
            </nav>
            <button type="button" aria-label="Zoeken" class="hidden lg:block text-white hover:text-[#F7C80C] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </button>
            <a href="/contact" class="hidden lg:inline-flex btn btn-primary">
                Get in contact
            </a>
            <button id="mobile-menu-toggle" type="button" aria-label="Menu openen" class="lg:hidden ml-auto text-white">
                <svg id="icon-hamburger" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </header>

    <?php get_template_part('resources/views/components/popup-bar'); ?>

    <div id="mobile-overlay" class="fixed inset-0 z-40 bg-gradient-to-r from-black/60 to-transparent hidden lg:hidden" aria-hidden="true"></div>
    <div id="mobile-menu" class="fixed top-0 right-0 z-50 h-full w-4/5 max-w-sm bg-gradient-to-b from-[#01B4C9] to-[#0F1733] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col lg:hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-white/20">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>" class="h-10 w-auto">
            </a>
            <button id="mobile-menu-close" type="button" aria-label="Menu sluiten" class="text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto px-6 py-6" role="navigation" aria-label="Mobiel menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container'      => false,
                'menu_class'     => 'flex flex-col gap-1',
                'walker'         => new class extends Walker_Nav_Menu {
                    public function start_lvl( &$output, $depth = 0, $args = null ) {
                        $output .= '<ul class="pl-4 mt-1 flex flex-col gap-1 hidden" data-submenu>' . "\n";
                    }
                    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
                        $classes      = empty($item->classes) ? [] : (array) $item->classes;
                        $has_children = in_array('menu-item-has-children', $classes);
                        $is_active    = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
                        $weight       = $is_active ? 'font-extrabold' : 'font-medium';
                        $href         = !empty($item->url) ? esc_url($item->url) : '#';
                        $title        = apply_filters('the_title', $item->title, $item->ID);

                        if ($has_children) {
                            $output .= '<li class="border-b border-white/10">';
                            $output .= '<div class="flex items-center justify-between">';
                            $output .= "<a href=\"$href\" class=\"flex-1 text-white text-base $weight py-2 hover:text-[#F7C80C] transition-colors\">$title</a>";
                            $output .= '<button type="button" data-submenu-toggle aria-label="Submenu uitklappen" class="text-white p-2 hover:text-[#F7C80C] transition-colors">';
                            $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>';
                            $output .= '</button>';
                            $output .= '</div>';
                        } else {
                            $a_class = "block text-white text-base $weight py-2 border-b border-white/10 hover:text-[#F7C80C] transition-colors";
                            $output .= "<li><a href=\"$href\" class=\"$a_class\">$title</a>";
                        }
                    }
                    public function end_el( &$output, $item, $depth = 0, $args = null ) {
                        $output .= "</li>\n";
                    }
                },
            ]);
            ?>
        </nav>
        <div class="px-6 py-6 border-t border-white/20">
            <a href="/contact" class="block text-center btn btn-primary w-full">Get in contact</a>
        </div>
    </div>
    <main class="min-h-full">
