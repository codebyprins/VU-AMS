<?php
$titel = get_sub_field('titel');
$teamleden = get_sub_field('teamleden');
?>

<section class="px-4 lg:px-0 py-10">
    <div class="container mx-auto">
        <div class="relative overflow-hidden bg-primary rounded-lg pt-6 pb-8 lg:overflow-visible lg:bg-white lg:border-[2px] lg:border-primary lg:px-[120px] lg:pt-[80px] lg:pb-[122px]">

            <?php if ($titel) : ?>
                <h2 class="text-center font-sans text-2xl mb-6 text-white lg:text-black"><?php echo esc_html($titel); ?></h2>
            <?php endif; ?>

            <?php if ($teamleden) : ?>
                <div class="relative flex items-center gap-2">
                    <button class="carrousel-prev text-4xl text-white flex-shrink-0 lg:text-6xl lg:text-primary px-2">&#8249;</button>

                    <div class="carrousel-window overflow-hidden flex-1">
                        <div class="carrousel-track flex">
                            <?php foreach ($teamleden as $lid) : ?>
                                <div class="carrousel-item flex-shrink-0 flex flex-col items-center text-center">
                                    <?php if ($lid['foto']) : ?>
                                        <img class="w-[100px] h-[100px] lg:w-[120px] lg:h-[120px] rounded-full object-cover mb-3 mx-auto"
                                             src="<?php echo esc_url($lid['foto']['url']); ?>"
                                             alt="<?php echo esc_html($lid['naam']); ?>">
                                    <?php else : ?>
                                        <div class="w-[100px] h-[100px] lg:w-[120px] lg:h-[120px] rounded-full bg-white/40 mb-3 mx-auto"></div>
                                    <?php endif; ?>
                                    <p class="carrousel-naam font-sans text-[16px] font-medium text-white lg:text-black"><?php echo esc_html($lid['naam']); ?></p>
                                    <p class="carrousel-functie font-sans text-[14px] text-white/80 lg:text-gray-500"><?php echo esc_html($lid['functie']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button class="carrousel-next text-4xl text-white flex-shrink-0 lg:text-6xl lg:text-primary px-2">&#8250;</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carrousel-track');
    const carrouselWindow = document.querySelector('.carrousel-window');
    const prev = document.querySelector('.carrousel-prev');
    const next = document.querySelector('.carrousel-next');
    const items = track.querySelectorAll('.carrousel-item');
    let index = 0;

    function isMobile() {
        return window.innerWidth < 768;
    }

    function updateTrack() {
        const windowWidth = carrouselWindow.offsetWidth;
        const itemWidth = isMobile() ? windowWidth * 0.75 : windowWidth / 5;
        const sideOffset = isMobile() ? (windowWidth - itemWidth) / 2 : 0;

        track.style.paddingLeft = sideOffset + 'px';

        items.forEach((item, i) => {
            item.style.width = itemWidth + 'px';
            const naam = item.querySelector('.carrousel-naam');
            const functie = item.querySelector('.carrousel-functie');
            if (isMobile()) {
                if (naam) naam.style.display = i === index ? 'block' : 'none';
                if (functie) functie.style.display = i === index ? 'block' : 'none';
            } else {
                if (naam) naam.style.display = 'block';
                if (functie) functie.style.display = 'block';
            }
        });

        track.style.transform = `translateX(-${index * itemWidth}px)`;
        track.style.transition = 'transform 0.3s ease';
    }

    next.addEventListener('click', function() {
        if (index < items.length - (isMobile() ? 1 : 5)) { index++; updateTrack(); }
    });

    prev.addEventListener('click', function() {
        if (index > 0) { index--; updateTrack(); }
    });

    updateTrack();
    window.addEventListener('resize', function() { index = 0; updateTrack(); });
});
</script>