<?php
$timeline_gradient = 'linear-gradient(180deg,#ffffff 0%,rgba(225,252,255,0.46) 55.77%,rgba(120,216,227,0.38) 78.37%,rgba(0,182,203,0.37) 100%)';

$timeline_items = get_sub_field('timeline') ?: [];
$timeline_previewwords = 50;
?>

<div class="relative w-full" style="background: <?php echo esc_attr($timeline_gradient); ?>;">
	<div class="mx-auto max-w-7xl px-6 py-20 lg:px-16 lg:py-28">
		<div class="relative">
			<!-- timeline line -->
			<div
				class=" absolute inset-y-0 left-5 w-[4px] -translate-x-1/2 bg-[#01b4c9] lg:left-1/2"
				aria-hidden="true">
			</div>

			<ol class="relative space-y-10 lg:space-y-0 lg:-space-y-32">
				<?php foreach ($timeline_items as $i => $item):
					$align_right = ($i % 2 === 0);
					$image = $item['image'] ?? '';

					$image_id = is_array($image)
						? (int) ($image['ID'] ?? $image['id'] ?? 0)
						: (int) $image;

					$image_url = is_array($image)
						? ($image['url'] ?? '')
						: '';

					$image_alt = is_array($image)
						? ($image['alt'] ?? '')
						: '';

					$title = $item['text'] ?? '';

					$body_plain = trim(
						preg_replace(
							'/\s+/',
							' ',
							wp_strip_all_tags($item['subtext'] ?? '')
						)
					);

					$words = $body_plain !== ''
						? preg_split('/\s+/', $body_plain)
						: [];

					$has_more = count($words) > $timeline_previewwords;
				?>

					<li class="relative pl-12 lg:pl-0">
						<!-- dot -->
						<span class="absolute top-8 left-5 lg:left-1/2 -translate-x-1/2 z-20 inline-flex h-[22px] w-[22px]
							rounded-full border-2 border-secondary bg-secondary"
							aria-hidden="true">
						</span>

						<!-- card wrapper -->
						<div class="
							w-full
							lg:w-[calc(50%-40px)]
							<?php echo $align_right ? 'lg:ml-auto' : ''; ?>
						">
							<article class=" relative z-10 w-full rounded-2xl bg-white p-6 text-black border border-black ">
								<?php if ($image_id || $image_url !== ''): ?>
									<div class="mb-4 overflow-hidden rounded-xl">
										<?php if ($image_id): ?>
											<?php echo wp_get_attachment_image(
												$image_id,
												'large',
												false,
												[
													'class' => 'h-auto max-h-[250px] lg:max-h-[400px] w-full object-contain'
												]
											); ?>
										<?php else: ?>
											<img
												src="<?php echo esc_url($image_url); ?>"
												alt="<?php echo esc_attr($image_alt); ?>"
												class=" h-auto max-h-[250px] lg:max-h-[400px] w-full object-contain " />
										<?php endif; ?>
									</div>
								<?php endif; ?>



								<h3 class="text-xl text-center">
									<?php echo esc_html($title); ?>
								</h3>

								<div class="mt-3 max-w-[65ch] text-base [&_p]:mb-2 [&_p:last-child]:mb-0">
									<?php if ($has_more): ?>
										<div
											class=" timeline-read-more-full hidden overflow-hidden transition-all duration-300 ease-in-out"
											style="max-height:0; opacity:0;">
											<p>
												<?php echo esc_html($body_plain); ?>
											</p>
										</div>

										<div class="mt-4 flex justify-center">
											<button
												type="button"
												class="
												timeline-read-more-js-toggle
												btn
												btn-primary
											"
												aria-expanded="false">
												Read more
											</button>
										</div>
									<?php else: ?>
										<p>
											<?php echo esc_html($body_plain); ?>
										</p>
									<?php endif; ?>
								</div>
							</article>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</div>
</section>