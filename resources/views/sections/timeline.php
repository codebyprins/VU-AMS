<?php
$timeline_gradient = 'linear-gradient(180deg,#ffffff 0%,rgba(225,252,255,0.46) 55.77%,rgba(120,216,227,0.38) 78.37%,rgba(0,182,203,0.37) 100%)';
if (empty($timeline_items)) {
	$timeline_items = [];
	if (function_exists('get_sub_field')) {
		$rows = get_sub_field('timeline'); 
		if (!empty($rows) && is_array($rows)) {
			foreach ($rows as $row) {
				$image = $row['image'] ?? null;
				if (is_array($image) && isset($image['ID'])) {
					$image_id = $image['ID'];
				} elseif (is_numeric($image)) {
					$image_id = (int) $image;
				} else {
					$image_id = null;
				}

				$timeline_items[] = [
					'image' => $image_id,
					'text' => $row['text'] ?? '',
					'subtext' => $row['subtext'] ?? '',
				];
			}
		}
	}
}
?>
	<div class="relative w-full border-t border-black/5" style="background: <?php echo esc_attr($timeline_gradient); ?>;">
		<div class="mx-auto max-w-7xl px-6 py-20 lg:px-16 lg:py-28">
			<div class="relative">
				<div
					class="absolute inset-y-0 left-5 w-[4px] -translate-x-1/2 bg-[#01b4c9] lg:left-1/2"
					aria-hidden="true"
				></div>

				<ol class="relative space-y-10 lg:space-y-14">
					<?php foreach ($timeline_items as $i => $item):
						$align_right = ($i % 2 === 0);
					?>
						<li class="relative">
							<span
								class="absolute top-6 z-10 inline-flex h-[22px] w-[22px] -translate-x-1/2 rounded-full border-2 border-[#f7c80c] bg-[#01b4c9] left-5 lg:left-1/2"
								aria-hidden="true"
							></span>

							<div class="pl-12 lg:grid lg:grid-cols-2 lg:gap-16 lg:pl-0">
								<?php if ($align_right): ?>
									<div class="hidden lg:block" aria-hidden="true"></div>
									<article class="w-full max-w-[600px] rounded-2xl bg-white p-6 text-black shadow-sm ring-1 ring-black/5">
										<?php if (!empty($item['image'])): ?>
											<div class="mb-4 overflow-hidden rounded-xl bg-black/5">
												<?php echo wp_get_attachment_image($item['image'], 'large', false, ['class' => 'h-auto max-h-[200px] w-full object-cover']); ?>
											</div>
										<?php endif; ?>
										<h3 class="text-xl font-normal leading-tight text-black">
											<?php echo esc_html($item['text']); ?>
										</h3>
										<div class="mt-3 max-w-[65ch] text-base leading-7 text-black [&_p]:mb-2 [&_p:last-child]:mb-0">
											<?php echo wp_kses_post(wpautop($item['subtext'])); ?>
										</div>
									</article>
								<?php else: ?>
									<article class="w-full max-w-[600px] rounded-2xl bg-white p-6 text-black shadow-sm ring-1 ring-black/5 lg:ml-auto">
										<?php if (!empty($item['image'])): ?>
											<div class="mb-4 overflow-hidden rounded-xl bg-black/5">
												<?php echo wp_get_attachment_image($item['image'], 'large', false, ['class' => 'h-auto max-h-[200px] w-full object-cover']); ?>
											</div>
										<?php endif; ?>
										<h3 class="text-xl font-normal leading-tight text-black">
											<?php echo esc_html($item['text']); ?>
										</h3>
										<div class="mt-3 max-w-[65ch] text-base leading-7 text-black [&_p]:mb-2 [&_p:last-child]:mb-0">
											<?php echo wp_kses_post(wpautop($item['subtext'])); ?>
										</div>
									</article>
									<div class="hidden lg:block" aria-hidden="true"></div>
								<?php endif; ?>
							</div>
							<div class="mt-4 h-px bg-black/10 lg:hidden"></div>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</div>

</section>