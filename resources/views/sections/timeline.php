<?php
// Load timeline fields
$title1 = get_sub_field('title1') ?: '';
$title2 = get_sub_field('title2') ?: '';
$title3 = get_sub_field('title3') ?: '';
$title4 = get_sub_field('title4') ?: '';

$subtext1 = get_sub_field('subtext1') ?: '';
$subtext2 = get_sub_field('subtext2') ?: '';
$subtext3 = get_sub_field('subtext3') ?: '';
$subtext4 = get_sub_field('subtext4') ?: '';

// Build fallback timeline items
$manual_timeline_items = [
	['title' => $title1, 'text' => $subtext1],
	['title' => $title2, 'text' => $subtext2],
	['title' => $title3, 'text' => $subtext3],
	['title' => $title4, 'text' => $subtext4],
];

// Load timeline items
$timeline_items = [];
if (function_exists('have_rows') && have_rows('timeline')) {
	while (have_rows('timeline')) {
		the_row();
		$timeline_items[] = [
			'title' => get_sub_field('title') ?: '',
			'text' => get_sub_field('text') ?: '',
			'subtext1' => get_sub_field('subtext1') ?: '',
			'subtext2' => get_sub_field('subtext2') ?: '',
			'subtext3' => get_sub_field('subtext3') ?: '',
			'subtext4' => get_sub_field('subtext4') ?: '',
		];
	}
}

// Use manual items as fallback if no items
if (empty($timeline_items)) {
	$timeline_items = array_values(array_filter($manual_timeline_items, static function ($item) {
		return $item['title'] !== '' || $item['text'] !== '';
	}));

	// Provide placeholder if empty
	if (empty($timeline_items)) {
		$timeline_items = array_fill(0, 4, ['title' => 'Titel', 'text' => '']);
	}
}

// Gradient (white → soft cyan)
$timeline_gradient = 'linear-gradient(180deg,#ffffff 0%,rgba(225,252,255,0.46) 55.77%,rgba(120,216,227,0.38) 78.37%,rgba(0,182,203,0.37) 100%)';
?>
	<!-- Timeline -->
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
									<article class="w-full max-w-[340px] rounded-2xl bg-white p-6 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5">
										<h3 class="text-xl font-normal leading-tight text-black">
											<?php echo esc_html($item['title']); ?>
										</h3>
										<div class="mt-3 text-sm leading-snug text-black [&_p]:mb-2 [&_p:last-child]:mb-0">
											<?php echo wp_kses_post(wpautop($item['text'])); ?>
										</div>
									</article>
								<?php else: ?>
									<article class="w-full max-w-[340px] rounded-2xl bg-white p-6 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5 lg:ml-auto">
										<h3 class="text-xl font-normal leading-tight text-black">
											<?php echo esc_html($item['title']); ?>
										</h3>
										<div class="mt-3 text-sm leading-snug text-black [&_p]:mb-2 [&_p:last-child]:mb-0">
											<?php echo wp_kses_post(wpautop($item['text'])); ?>
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