<?php
$titel = get_sub_field('titel');
$product_logo = get_sub_field('product_logo');

$releases = get_posts([
    'post_type'      => 'software-release',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC',
]);
?>

<section class="px-4 py-8 md:px-[131px] md:py-12">

    <?php if ($titel) : ?>
        <h2 class="font-sans text-2xl md:text-4xl font-bold mb-2"><?php echo esc_html($titel); ?></h2>
        <div class="w-full h-[2px] bg-secondary mb-4"></div>
    <?php endif; ?>

    <?php if ($releases) : ?>
        <div class="border border-gray-300 rounded-lg overflow-hidden">

            <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-8 p-6">

                <!-- Logo -->
                <?php if ($product_logo) : ?>
                    <img src="<?php echo esc_url($product_logo['url']); ?>"
                         alt="<?php echo esc_html($product_logo['alt']); ?>"
                         class="w-12 h-12 object-contain flex-shrink-0 bg-gray-100 rounded">
                <?php else : ?>
                    <div class="w-12 h-12 bg-gray-200 flex-shrink-0 rounded"></div>
                <?php endif; ?>

                <!-- MacOS -->
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

                <!-- Windows -->
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

                <!-- Small text -->
                <div id="small-text" class="text-sm text-gray-500 max-w-[600px]"></div>

                <!-- Changelog knop -->
                <button id="changelog-toggle"
                        class="btn btn-primary-outline w-full md:w-auto md:ml-auto">
                    Changelog
                </button>
            </div>

            <!-- Changelog sectie -->
            <div id="changelog-content" class="bg-gray-100 border-t border-gray-200 p-6">
                <?php foreach ($releases as $index => $release) : ?>
                    <?php
                    $changelog = get_field('changelog', $release->ID);
                    $small_text = get_field('small_text', $release->ID);
                    $macos = get_field('macos_download', $release->ID);
                    $windows = get_field('windows_download', $release->ID);
                    ?>
                    <div class="changelog-item hidden" data-index="<?php echo $index; ?>"
                         data-macos="<?php echo esc_url($macos['url'] ?? '#'); ?>"
                         data-windows="<?php echo esc_url($windows['url'] ?? '#'); ?>"
                         data-small-text="<?php echo esc_attr($small_text ?? ''); ?>">
                        <div class="text-sm text-gray-700"><?php echo $changelog; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const macosSelect = document.getElementById('macos-select');
    const windowsSelect = document.getElementById('windows-select');
    const macosDownload = document.getElementById('macos-download');
    const windowsDownload = document.getElementById('windows-download');
    const changelogToggle = document.getElementById('changelog-toggle');
    const changelogContent = document.getElementById('changelog-content');
    const changelogItems = document.querySelectorAll('.changelog-item');
    const smallText = document.getElementById('small-text');
    const lastIndex = changelogItems.length - 1;

    function updateDownloads() {
        const index = macosSelect.value;
        const activeItem = document.querySelector(`.changelog-item[data-index="${index}"]`);
        if (activeItem) {
            macosDownload.href = activeItem.dataset.macos;
            windowsDownload.href = activeItem.dataset.windows;
            smallText.textContent = activeItem.dataset.smallText;
            changelogItems.forEach(item => item.classList.add('hidden'));
            activeItem.classList.remove('hidden');
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

    macosSelect.value = lastIndex;
    windowsSelect.value = lastIndex;
    updateDownloads();
});
</script>