<?php
$items        = get_sub_field('testimonial_items');
if (!$items) return;

$groups       = array_chunk($items, 3);
$carousel_id  = 'testimonial-carousel-' . get_the_ID();
$has_multiple = count($groups) > 1;
?>

<section class="w-full py-12 sm:py-16">
	<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
		<div id="<?php echo esc_attr($carousel_id); ?>" class="relative">

			<?php foreach ($groups as $group_index => $group) : ?>
				<div
					class="testimonial-group<?php echo $group_index === 0 ? ' is-active' : ''; ?>"
					aria-hidden="<?php echo $group_index === 0 ? 'false' : 'true'; ?>">

					<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
						<?php foreach ($group as $item) :
							$image       = $item['image'] ?? '';
							$image_url   = is_array($image) ? ($image['url'] ?? '') : (string) $image;
							$image_alt   = is_array($image) ? ($image['alt'] ?? '') : '';
							$content     = wp_trim_words(wp_strip_all_tags($item['content'] ?? ''), 40, '&hellip;');
							$name        = $item['name'] ?? '';
							$job_title   = $item['job_title'] ?? '';
							$institution = $item['institution'] ?? '';
						?>
							<div class="flex flex-col items-center rounded-2xl bg-[#F3F3F3] px-8 py-10 text-center">

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
						<?php endforeach; ?>
					</div>

				</div>
			<?php endforeach; ?>

		</div>
	</div>
</section>

<style>
	.testimonial-group {
		opacity: 0;
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		transition: opacity 0.8s ease;
		pointer-events: none;
	}

	.testimonial-group.is-active {
		opacity: 1;
		position: relative;
		pointer-events: auto;
	}
</style>

<?php if ($has_multiple) : ?>
<script>
(function () {
	var carousel = document.getElementById('<?php echo esc_js($carousel_id); ?>');
	if (!carousel) return;

	var groups  = carousel.querySelectorAll('.testimonial-group');
	var total   = groups.length;
	if (total < 2) return;
	var current = 0;

	function goTo(index) {
		groups[current].classList.remove('is-active');
		groups[current].setAttribute('aria-hidden', 'true');
		current = (index + total) % total;
		groups[current].classList.add('is-active');
		groups[current].setAttribute('aria-hidden', 'false');
	}

	setInterval(function () { goTo(current + 1); }, 10000);
}());
</script>
<?php endif; ?>