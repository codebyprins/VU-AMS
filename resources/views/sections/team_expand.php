<?php
$titel = get_sub_field('titel');

$teamleden = get_posts([
    'post_type'      => 'team-member',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC',
]);
?>

<section class="px-4 md:px-0 py-16">
    <div class="container mx-auto">

        <?php if ($titel) : ?>
            <h2 class="text-center text-3xl font-bold mb-12 text-white">
                <?php echo esc_html($titel); ?>
            </h2>
        <?php endif; ?>

        <?php if ($teamleden) : ?>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 items-start">

                <?php foreach ($teamleden as $lid) :
                    $image       = get_field('foto', $lid->ID);
                    $name        = get_the_title($lid->ID);
                    $function    = get_field('functie', $lid->ID);
                    $description = get_field('description', $lid->ID);

                    $image_url = is_array($image) ? $image['url'] : $image;
                ?>

                    <div class="team-card w-[276px] bg-white rounded-2xl border-[4px] border-[#01B4C9] flex flex-col items-center text-center p-6 gap-4">

                        <?php if ($image_url) : ?>
                            <img
                                src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr($name); ?>"
                                class="w-36 h-36 object-cover rounded-xl"
                            >
                        <?php else : ?>
                            <div class="w-36 h-36 bg-gray-200 rounded-xl"></div>
                        <?php endif; ?>

                        <div class="text-lg font-bold text-gray-800">
                            <?php echo esc_html($name); ?>
                        </div>

                        <?php if ($function) : ?>
                            <div class="text-sm text-teal-600 tracking-wide -mt-2">
                                <?php echo esc_html($function); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($description) : ?>
                            <div class="team-accordion w-full">
                                <button class="accordion-toggle bg-[#01B4C9] hover:bg-[#0d7a86] text-white text-sm font-semibold px-6 py-2 rounded-full transition-colors duration-100">
                                    Read more
                                </button>
                                <div class="accordion-body overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                                    <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                                        <?php echo wp_kses_post($description); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                <?php endforeach;
                wp_reset_postdata(); ?>

            </div>
        <?php endif; ?>

    </div>
</section>