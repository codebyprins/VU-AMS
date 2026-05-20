<?php
$titel = get_sub_field('titel');
$product_naam = get_sub_field('product_naam');
$product_logo = get_sub_field('product_logo');
$versies = get_sub_field('versies');
?>

<section class="px-4 py-8 md:px-[131px] md:py-12">

    <?php if ($titel) : ?>
        <h2 class="font-sans text-2xl md:text-4xl font-bold mb-2"><?php echo esc_html($titel); ?></h2>
        <div class="w-full h-[2px] bg-secondary mb-4"></div>
    <?php endif; ?>

    <?php if ($product_naam) : ?>
        <p class="text-sm text-gray-500 mb-3"><?php echo esc_html($product_naam); ?></p>
    <?php endif; ?>

    <?php if ($versies) : ?>
        <div class="border border-gray-300 rounded-lg overflow-hidden">

            <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-8 p-6">

                <?php if ($product_logo) : ?>
                    <img src="<?php echo esc_url($product_logo['url']); ?>"
                         alt="<?php echo esc_html($product_logo['alt']); ?>"
                         class="w-12 h-12 object-contain flex-shrink-0 bg-gray-100 rounded">
                <?php else : ?>
                    <div class="w-12 h-12 bg-gray-200 flex-shrink-0 rounded"></div>
                <?php endif; ?>

                <div class="flex flex-col gap-1 w-full md:w-auto">
                    <span class="text-sm font-medium">MacOS</span>
                    <select id="macos-select" class="border border-secondary rounded px-3 py-2 text-sm w-full md:w-auto">
                        <?php foreach ($versies as $index => $versie) : ?>
                            <option value="<?php echo $index; ?>"><?php echo esc_html($versie['versie_naam']); ?></option>
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
                        <?php foreach ($versies as $index => $versie) : ?>
                            <option value="<?php echo $index; ?>"><?php echo esc_html($versie['versie_naam']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a id="windows-download" href="#"
                       class="border border-primary bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary/90 text-center w-full md:w-auto">
                        Download
                    </a>
                </div>

                <button id="changelog-toggle"
                        class="border border-secondary text-secondary px-5 py-2 rounded text-sm hover:bg-secondary/10 w-full md:w-auto md:ml-auto">
                    Changelog
                </button>
            </div>

            <div id="changelog-content" class="bg-gray-100 border-t border-gray-200 p-6">
                <?php foreach ($versies as $index => $versie) : ?>
                    <div class="changelog-item hidden" data-index="<?php echo $index; ?>">
                        <div class="text-sm text-gray-700"><?php echo $versie['changelog']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const versies = <?php echo json_encode(array_map(function($v) {
        return [
            'macos' => isset($v['macos_download']['url']) ? $v['macos_download']['url'] : '#',
            'windows' => isset($v['windows_download']['url']) ? $v['windows_download']['url'] : '#',
        ];
    }, $versies)); ?>;

    const macosSelect = document.getElementById('macos-select');
    const windowsSelect = document.getElementById('windows-select');
    const macosDownload = document.getElementById('macos-download');
    const windowsDownload = document.getElementById('windows-download');
    const changelogToggle = document.getElementById('changelog-toggle');
    const changelogContent = document.getElementById('changelog-content');
    const changelogItems = document.querySelectorAll('.changelog-item');
    const lastIndex = versies.length - 1;

    function updateDownloads() {
        const index = macosSelect.value;
        macosDownload.href = versies[index].macos;
        windowsDownload.href = versies[index].windows;
        changelogItems.forEach(item => item.classList.add('hidden'));
        const activeItem = document.querySelector(`.changelog-item[data-index="${index}"]`);
        if (activeItem) activeItem.classList.remove('hidden');
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