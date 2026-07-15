<?php
$titel               = get_sub_field('titel');
$product_logo        = get_sub_field('product_logo');
$product_naam        = get_sub_field('product__naam');
$category            = get_sub_field('category');
$changelog_versions  = get_sub_field('changelog_all_versions');

$term_ids = [];
if ($category) {
    if (is_array($category)) {
        foreach ($category as $term) {
            $term_ids[] = is_object($term) ? $term->term_id : (int)$term;
        }
    } else {
        $term_ids[] = is_object($category) ? $category->term_id : (int)$category;
    }
}

$releases = get_posts([
    'post_type'      => 'software-release',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC',
    'tax_query'      => !empty($term_ids) ? [[
        'taxonomy' => 'download-category',
        'field'    => 'term_id',
        'terms'    => $term_ids,
    ]] : [],
]);
?>

<section class="download-block container mx-auto px-4 py-8 md:py-12">

    <?php if ($titel) : ?>
        <h2 class="font-sans text-2xl md:text-4xl font-bold mb-2"><?php echo esc_html($titel); ?></h2>
        <div class="w-full h-[2px] bg-secondary mb-4"></div>
    <?php endif; ?>

    <?php if ($releases) : ?>
        <div class="border border-gray-300 rounded-lg overflow-hidden">

            <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-8 p-6">

                <div class="flex flex-col items-start gap-1 flex-shrink-0">
                    <?php if ($product_naam) : ?>
                        <p class="text-sm font-semibold text-gray-700"><?php echo esc_html($product_naam); ?></p>
                    <?php endif; ?>
                    <?php if ($product_logo) : ?>
                        <img src="<?php echo esc_url($product_logo['url']); ?>"
                             alt="<?php echo esc_html($product_logo['alt']); ?>"
                             class="w-12 h-12 object-contain bg-gray-100 rounded">
                    <?php else : ?>
                        <div class="w-12 h-12 bg-gray-200 rounded"></div>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col gap-1 w-full md:w-auto">
                    <span class="text-sm font-medium">MacOS</span>
                    <select id="macos-select" class="border border-secondary rounded px-3 py-2 text-sm w-full md:w-auto">
                        <?php foreach ($releases as $index => $release) : ?>
                            <option value="<?php echo $index; ?>"><?php echo esc_html($release->post_title); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a id="macos-download" href="#"
                       class="border border-primary bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary/90 text-center w-full md:w-auto">
                        Download
                    </a>
                </div>

                <div class="flex flex-col gap-1 w-full md:w-auto">
                    <span class="text-sm font-medium">Windows</span>
                    <select id="windows-select" class="border border-secondary rounded px-3 py-2 text-sm w-full md:w-auto">
                        <?php foreach ($releases as $index => $release) : ?>
                            <option value="<?php echo $index; ?>"><?php echo esc_html($release->post_title); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a id="windows-download" href="#"
                       class="border border-primary bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary/90 text-center w-full md:w-auto">
                        Download
                    </a>
                </div>

                <div id="small-text" class="text-sm text-gray-500 max-w-3xl"></div>

                <button id="changelog-toggle"
                        class="btn btn-primary-outline w-full md:w-auto md:ml-auto">
                    Changelog
                </button>
            </div>

            <div id="changelog-content" class="hidden bg-gray-50 border-t border-gray-200 p-6">

                <!-- Verborgen per-release changelog HTML -->
                <div class="release-changelogs" hidden aria-hidden="true">
                    <?php foreach ($releases as $index => $release) : ?>
                        <div data-index="<?php echo $index; ?>">
                            <?php echo wp_kses_post(get_field('changelog', $release->ID) ?? ''); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Verborgen per-release small_text -->
                <div class="release-small-texts" hidden aria-hidden="true">
                    <?php foreach ($releases as $index => $release) : ?>
                        <div data-index="<?php echo $index; ?>"><?php echo esc_html(get_field('small_text', $release->ID) ?? ''); ?></div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($changelog_versions) && is_array($changelog_versions)) : ?>
                    <div class="flex flex-col gap-2">
                        <?php foreach ($changelog_versions as $version_item) : ?>
                            <div class="changelog-version rounded-lg border border-gray-200 bg-white overflow-hidden">
                                <div class="changelog-version-header flex items-center justify-between px-4 py-3 cursor-pointer select-none hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800"><?php echo esc_html($version_item['version']); ?></span>
                                    <button type="button" class="changelog-read-more flex items-center gap-1 text-primary text-sm font-medium hover:underline">
                                        <span class="read-more-label">Lees meer</span>
                                        <svg class="read-more-icon w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="changelog-version-body border-t border-gray-100 px-4 text-sm text-gray-700 prose max-w-none overflow-hidden" style="max-height:0;transition:max-height 0.35s ease,padding 0.35s ease;padding-top:0;padding-bottom:0;">
                                    <?php echo wp_kses_post($version_item['version_description']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="text-sm text-gray-400 italic">Geen changelog beschikbaar.</p>
                <?php endif; ?>

                <!-- Changelog van geselecteerde release -->
                <div id="release-changelog-display" class="prose max-w-none text-sm text-gray-700 mt-6"></div>

            </div>
        </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Werk met alle download blocks
    document.querySelectorAll('.download-block').forEach(function(block) {
        const macosSelect     = block.querySelector('#macos-select');
        const windowsSelect   = block.querySelector('#windows-select');
        const macosDownload   = block.querySelector('#macos-download');
        const windowsDownload = block.querySelector('#windows-download');
        const changelogToggle  = block.querySelector('#changelog-toggle');
        const changelogContent = block.querySelector('#changelog-content');
        const smallText        = block.querySelector('#small-text');
        const releaseChangelogDisplay = block.querySelector('#release-changelog-display');
        const releaseChangelogs = block.querySelectorAll('.release-changelogs [data-index]');

        // Releases data from PHP
        const releasesData = <?php
            $data = [];
            foreach ($releases as $index => $release) {
                $macos      = get_field('macos_download', $release->ID);
                $windows    = get_field('windows_download', $release->ID);
                $small_text = get_field('small_text', $release->ID);
                $data[] = [
                    'index'     => $index,
                    'macos'     => is_array($macos) ? ($macos['url'] ?? '#') : ($macos ?? '#'),
                    'windows'   => is_array($windows) ? ($windows['url'] ?? '#') : ($windows ?? '#'),
                    'smallText' => $small_text ?? '',
                ];
            }
            echo json_encode($data);
        ?>;

        function updateDownloads() {
            const index = parseInt(macosSelect.value);
            const release = releasesData.find(r => r.index === index);
            if (release) {
                macosDownload.href   = release.macos;
                windowsDownload.href = release.windows;
            }
            // Small text uit verborgen DOM
            const smallTextEl = block.querySelector(`.release-small-texts [data-index="${index}"]`);
            if (smallText) {
                smallText.textContent = smallTextEl ? smallTextEl.textContent.trim() : '';
            }
            // Changelog uit verborgen DOM
            if (releaseChangelogDisplay) {
                const changelogEl = block.querySelector(`.release-changelogs [data-index="${index}"]`);
                releaseChangelogDisplay.innerHTML = changelogEl ? changelogEl.innerHTML.trim() : '';
            }
        }

        macosSelect.addEventListener('change', function() {
            windowsSelect.value = this.value;
            updateDownloads();
        });

        windowsSelect.addEventListener('change', function() {
            macosSelect.value = this.value;
            updateDownloads();
        });

        changelogToggle.addEventListener('click', function() {
            changelogContent.classList.toggle('hidden');
        });

        // Expand/collapse version descriptions
        block.addEventListener('click', function(e) {
            const btn = e.target.closest('.changelog-read-more');
            if (!btn) return;
            const versionItem = btn.closest('.changelog-version');
            const body  = versionItem.querySelector('.changelog-version-body');
            const label = btn.querySelector('.read-more-label');
            const icon  = btn.querySelector('.read-more-icon');
            const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';
            if (isOpen) {
                body.style.maxHeight  = '0';
                body.style.paddingTop    = '0';
                body.style.paddingBottom = '0';
            } else {
                body.style.paddingTop    = '1rem';
                body.style.paddingBottom = '1rem';
                body.style.maxHeight  = body.scrollHeight + 32 + 'px';
            }
            label.textContent    = isOpen ? 'Lees meer' : 'Inklappen';
            icon.style.transform = isOpen ? '' : 'rotate(180deg)';
        });

        macosSelect.selectedIndex  = macosSelect.options.length - 1;
        windowsSelect.selectedIndex = windowsSelect.options.length - 1;
        updateDownloads();
    });
});
</script>