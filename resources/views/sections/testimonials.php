<?php
$items        = get_sub_field('testimonial_items');
if (!$items) return;

$total        = count($items);
$carousel_id  = 'testimonial-carousel-' . get_the_ID();
$has_multiple = $total > 1;
?>

<section class="w-full py-12 sm:py-16">
	<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
		<div class="flex items-center gap-2 sm:gap-4">

		<?php if ($has_multiple) : ?>
		<button type="button" class="testimonial-prev flex-shrink-0 flex items-center justify-center text-primary transition-opacity hover:opacity-60" aria-label="Vorige testimonials" aria-controls="<?php echo esc_attr($carousel_id); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-6 h-6 md:w-8 md:h-8" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
			</svg>
		</button>
		<?php endif; ?>

			<div id="<?php echo esc_attr($carousel_id); ?>" class="testimonial-carousel flex-1">

				<?php foreach ($items as $i => $item) :
					$image       = $item['image'] ?? '';
					$image_url   = is_array($image) ? ($image['url'] ?? '') : (string) $image;
					$image_alt   = is_array($image) ? ($image['alt'] ?? '') : '';
					$content     = wp_trim_words(wp_strip_all_tags($item['content'] ?? ''), 40, '&hellip;');
					$name        = $item['name'] ?? '';
					$job_title   = $item['job_title'] ?? '';
					$institution = $item['institution'] ?? '';
				?>
					<div class="testimonial-item" data-index="<?php echo (int) $i; ?>" aria-hidden="true">

						<div class="flex flex-col items-center rounded-2xl bg-[#F3F3F3] px-8 py-10 text-center h-full">

							<div class="mb-5 flex h-14 w-14 items-center justify-center">
								<?php if (!empty($image_url)) : ?>
									<img
										src="<?php echo esc_url($image_url); ?>"
										alt="<?php echo esc_attr($image_alt); ?>"
										class="h-14 w-14 rounded-full object-cover"
									/>
								<?php else : ?>
									<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="#00B6CB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
										<line x1="16" y1="8" x2="2" y2="22"></line>
										<line x1="17.5" y1="15" x2="9" y2="15"></line>
									</svg>
								<?php endif; ?>
							</div>

							<?php if ($content) : ?>
								<p class="mb-5 text-sm leading-relaxed text-slate-600">
									&ldquo;<?php echo esc_html($content); ?>&rdquo;
								</p>
							<?php endif; ?>

							<?php if ($name) : ?>
								<p class="text-2xl font-bold text-slate-900"><?php echo esc_html($name); ?></p>
							<?php endif; ?>

							<?php if ($job_title) : ?>
								<p class="mt-1 text-slate-900"><?php echo esc_html($job_title); ?></p>
							<?php endif; ?>

							<?php if ($institution) : ?>
								<p class="mt-1 text-slate-900"><?php echo esc_html($institution); ?></p>
							<?php endif; ?>

						</div>

					</div>
				<?php endforeach; ?>

			</div>

		<?php if ($has_multiple) : ?>
		<button type="button" class="testimonial-next flex-shrink-0 flex items-center justify-center text-primary transition-opacity hover:opacity-60" aria-label="Volgende testimonials" aria-controls="<?php echo esc_attr($carousel_id); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-6 h-6 md:w-8 md:h-8" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
			</svg>
		</button>
		<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.testimonial-carousel {
		display: grid;
		gap: 1.5rem;
		transition: opacity 0.4s ease;
	}
	@media (min-width: 640px) {
		.testimonial-carousel { grid-template-columns: repeat(2, 1fr); }
	}
	@media (min-width: 1024px) {
		.testimonial-carousel { grid-template-columns: repeat(3, 1fr); }
	}

	.testimonial-item {
		display: none;
	}
	.testimonial-item.is-visible {
		display: flex;
		flex-direction: column;
	}
</style>

<?php if ($has_multiple) : ?>
<script>
(function () {
	var carousel = document.getElementById('<?php echo esc_js($carousel_id); ?>');
	if (!carousel) return;

	var allItems = Array.prototype.slice.call(carousel.querySelectorAll('.testimonial-item'));
	var total    = allItems.length;
	if (total < 2) return;

	var current = 0;
	var timer   = null;

	function perPage() {
		return window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 640 ? 2 : 1);
	}

	function goTo(index, animate) {
		var pp  = perPage();
		var max = total - pp;
		current = Math.max(0, Math.min(((index % total) + total) % total, max));

		function applyItems() {
			allItems.forEach(function (item, i) {
				var visible = i >= current && i < current + pp;
				item.classList.toggle('is-visible', visible);
				item.setAttribute('aria-hidden', visible ? 'false' : 'true');
			});
		}

		if (animate) {
			carousel.style.opacity = '0';
			setTimeout(function () {
				applyItems();
				carousel.style.opacity = '1';
			}, 400);
		} else {
			applyItems();
		}
	}

	function startAutoplay() {
		if (timer) clearInterval(timer);
		timer = setInterval(function () {
			var pp   = perPage();
			var next = current + pp >= total ? 0 : current + pp;
			goTo(next, true);
		}, 10000);
	}

	var wrapper = carousel.parentElement;
	var prev = wrapper ? wrapper.querySelector('.testimonial-prev') : null;
	var next = wrapper ? wrapper.querySelector('.testimonial-next') : null;

	if (prev) prev.addEventListener('click', function () { goTo(current - perPage(), true); startAutoplay(); });
	if (next) next.addEventListener('click', function () { goTo(current + perPage(), true); startAutoplay(); });

	goTo(0, false);
	startAutoplay();
}());
</script>
<?php endif; ?>