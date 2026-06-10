<?php
$publications_page = get_page_by_path('publications');
$publications_url = $publications_page ? get_permalink($publications_page) : home_url();
$back_url = wp_get_referer() ?: $publications_url;
$default  = $publications_url;
?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php
        $publication_id = get_the_ID();

        // Fetch all publication metadata
        $url = get_post_meta($publication_id, 'source_url', true)
            ?: get_post_meta($publication_id, 'publication_url', true);

        $doi = get_post_meta($publication_id, 'doi', true);

        $publication_title = get_post_meta(
            $publication_id,
            'publication_title',
            true
        );

        $abstract = get_the_content();

        $authors = get_the_terms(
            $publication_id,
            'publication_author'
        );

        $publication_date = get_post_meta(
            $publication_id,
            'publication_date',
            true
        );

        $years = get_the_terms(
            $publication_id,
            'publication_year'
        );

        $is_pdf = $url && str_contains(
            strtolower($url),
            '.pdf'
        );

        $tags = get_the_terms(
            $publication_id,
            'publication_keyword'
        );

        ?>

        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 max-w-4xl">
                <?php
                theme_button([
                    'text'  => 'Go Back',
                    'url'   => $back_url ?: $default,
                    'icon'  => 'arrow-left',
                    'color' => 'primary',
                    'style' => 'primary-outline',
                ]);
                ?>

                <h2 class=" mb-6">
                    <?php the_title(); ?>
                </h2>

                <?php if ($authors && !is_wp_error($authors)) : ?>
                    <div class="mb-4">
                        <h5>Authors:</h4>
                            <?= esc_html(
                                implode(
                                    ', ',
                                    wp_list_pluck($authors, 'name')
                                )
                            ); ?>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col md:flex-row md:gap-6">
                    <?php if ($publication_date) : ?>
                        <div class="mb-4">
                            <h5>Publication date:</h5>
                            <?= esc_html($publication_date); ?>
                        </div>
                    <?php elseif ($years && !is_wp_error($years)) : ?>
                        <div class="mb-4">
                            <h5>Publication year:</h5>
                            <?= esc_html(
                                implode(
                                    ', ',
                                    wp_list_pluck($years, 'name')
                                )
                            ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($publication_title) : ?>
                        <div class="mb-4">
                            <h5>Journal/Publication:</h5>
                            <?= esc_html($publication_title); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($doi) : ?>
                        <div class="mb-6">
                            <h5>DOI:</h5>
                            <a href="<?= esc_url('https://doi.org/' . $doi); ?>" target="_blank" class="text-blue-600 hover:underline">
                                <?= esc_html($doi); ?>
                            </a>
                        </div>

                    <?php endif; ?>
                </div>

                <?php if ($tags && !is_wp_error($tags)) : ?>
                    <div class="mb-8">
                        <h5>Tags:</h5>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($tags as $tag) : ?>
                                <span class="bg-primary px-2 py-1 rounded-full text-white text-sm">
                                    <?= esc_html($tag->name); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($abstract)) : ?>
                    <div class="mb-8">
                        <h4 class="mb-4">Abstract</h3>
                            <div class="prose">
                                <?= wp_kses_post($abstract); ?>
                            </div>
                    </div>

                <?php endif; ?>

                <?php if ($url) : ?>
                    <div class="mt-8">
                        <?php
                        theme_button([
                            'text'   => $is_pdf ? 'Open PDF' : 'Visit Publication',
                            'url'    => $url,
                            'icon'   => $is_pdf ? 'file' : 'link',
                            'target' => '_blank',
                            'style'  => 'primary',
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>