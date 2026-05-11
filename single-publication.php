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

        $years = get_the_terms(
            $publication_id,
            'publication_year'
        );

        $keywords = get_the_terms(
            $publication_id,
            'publication_keyword'
        );

        $is_pdf = $url && str_contains(
            strtolower($url),
            '.pdf'
        );

        ?>

        <section class="py-16 bg-white">

            <div class="container mx-auto px-4 max-w-4xl">

                <h1 class="text-4xl font-bold mb-6">
                    <?php the_title(); ?>
                </h1>

                <?php if ($authors && !is_wp_error($authors)) : ?>

                    <div class="mb-4">

                        <strong>Authors:</strong>

                        <?= esc_html(
                            implode(
                                ', ',
                                wp_list_pluck($authors, 'name')
                            )
                        ); ?>

                    </div>

                <?php endif; ?>

                <?php if ($years && !is_wp_error($years)) : ?>

                    <div class="mb-4">

                        <strong>Year:</strong>

                        <?= esc_html($years[0]->name); ?>

                    </div>

                <?php endif; ?>

                <?php if ($publication_title) : ?>

                    <div class="mb-4">

                        <strong>Journal/Publication:</strong>

                        <?= esc_html($publication_title); ?>

                    </div>

                <?php endif; ?>

                <?php if ($doi) : ?>

                    <div class="mb-6">

                        <strong>DOI:</strong>

                        <a href="<?= esc_url('https://doi.org/' . $doi); ?>" target="_blank" class="text-blue-600 hover:underline">
                            <?= esc_html($doi); ?>
                        </a>

                    </div>

                <?php endif; ?>

                <?php if (!empty($keywords)) : ?>

                    <div class="flex flex-wrap gap-2 mb-8">

                        <?php foreach ($keywords as $keyword) : ?>

                            <span class="bg-[#F6DD75] border border-black px-3 py-1 rounded-full text-sm">

                                <?= esc_html($keyword->name); ?>

                            </span>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

                <?php if (!empty($abstract)) : ?>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Abstract</h2>
                        <div class="prose max-w-none bg-gray-50 p-6 rounded-lg">
                            <?= wp_kses_post($abstract); ?>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if ($url) : ?>

                    <div class="mt-8">
                        <?php if ($is_pdf) : ?>

                            <a
                                href="<?= esc_url($url); ?>"
                                target="_blank"
                                class="btn btn-primary inline-block bg-[#01B4C9] hover:bg-[#009aa3] text-white font-bold py-3 px-6 rounded transition"
                            >
                                📄 Open PDF
                            </a>

                        <?php else : ?>

                            <a
                                href="<?= esc_url($url); ?>"
                                target="_blank"
                                class="btn btn-primary inline-block bg-[#01B4C9] hover:bg-[#009aa3] text-white font-bold py-3 px-6 rounded transition"
                            >
                                🔗 Visit Publication
                            </a>

                        <?php endif; ?>
                    </div>

                <?php endif; ?>

            </div>

        </section>

    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>