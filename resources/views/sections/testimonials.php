<?php
$items = get_sub_field('testimonial_items');
if (!$items) return;
$total = count($items);
$carousel_id = 'testimonial-carousel-' . get_the_ID();
?>

<section class="container mx-auto px-4 py-10 flex-center">
    <div class="relative" id="<?php echo esc_attr($carousel_id); ?>">

        <div class="testimonial-track">

            <?php foreach ($items as $index => $item) :
                $image     = $item['image'];
                $image_url = is_array($image) ? $image['url'] : $image;
                $image_alt = is_array($image) ? $image['alt'] : '';
                $content   = wp_trim_words(wp_strip_all_tags($item['content']), 40, '...');
            ?>
                <div
                    class="testimonial-slide<?php echo $index === 0 ? ' is-active' : ''; ?>"
                    aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>">
                    <div class="relative w-full min-h-[240px] md:min-h-[460px] flex items-center justify-center overflow-hidden">
                        <img
                            src="<?php echo esc_url($image_url); ?>"
                            alt="<?php echo esc_attr($image_alt); ?>"
                            class="absolute inset-0 w-full h-full object-cover" />

                        <div class="absolute inset-0" style="background-color: rgba(16,25,53,0.6);"></div>

                        <div class="relative z-10 text-center text-white px-16 sm:px-24 md:px-36 lg:px-56 py-8 md:py-20 max-w-5xl mx-auto">
                            <div class="text-sm sm:text-lg md:text-2xl lg:text-3xl font-medium md:!leading-[45px] leading-[30px]">
                                <?php echo esc_html($content); ?>
                            </div>
                            <div class="text-sm sm:text-lg md:text-2xl lg:text-3xl font-medium leading-normal sm:leading-relaxed md:leading-loose">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <button
            class="testimonial-prev absolute left-4 md:left-6 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center text-white shadow-md hover:opacity-75 transition-opacity"
            style="background-color: #00B6CB;"
            aria-label="Vorige testimonial">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <button
            class="testimonial-next absolute right-4 md:right-6 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center text-white shadow-md hover:opacity-75 transition-opacity"
            style="background-color: #00B6CB;"
            aria-label="Volgende testimonial">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>

    </div>
</section>

<style>
    .testimonial-track {
        position: relative;
    }

    .testimonial-slide {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        transition: opacity 0.7s ease;
        pointer-events: none;
    }

    .testimonial-slide.is-active {
        position: relative;
        opacity: 1;
        pointer-events: auto;
    }
</style>

<script>
    (function() {
        var carousel = document.getElementById('<?php echo esc_js($carousel_id); ?>');
        if (!carousel) return;

        var slides = carousel.querySelectorAll('.testimonial-slide');
        var total = slides.length;
        var current = 0;
        var autoplay;

        function goTo(index) {
            slides[current].classList.remove('is-active');
            slides[current].setAttribute('aria-hidden', 'true');

            current = (index + total) % total;

            slides[current].classList.add('is-active');
            slides[current].setAttribute('aria-hidden', 'false');
        }

        function resetAutoplay() {
            clearInterval(autoplay);
            autoplay = setInterval(function() {
                goTo(current + 1);
            }, 6000);
        }

        carousel.querySelector('.testimonial-prev').addEventListener('click', function() {
            goTo(current - 1);
            resetAutoplay();
        });

        carousel.querySelector('.testimonial-next').addEventListener('click', function() {
            goTo(current + 1);
            resetAutoplay();
        });

        resetAutoplay();
    }());
</script>