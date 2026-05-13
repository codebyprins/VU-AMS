<?php
$image = get_sub_field('image') ?: '';
$title = get_sub_field('title') ?: '';
$subtext = get_sub_field('subtext') ?: '';
$icon = get_sub_field('icon') ?: '';
$date = get_sub_field('date') ?: '';
$display_title = $title;


$icon_markup = '';
if (is_object($icon) && !empty($icon->element)) {
	$icon_markup = $icon->element;
} elseif (is_array($icon) && !empty($icon['element'])) {
	$icon_markup = $icon['element'];
} elseif (is_array($icon) && !empty($icon['class'])) {
	// Handle if it only has class property
	$icon_markup = '<i class="' . esc_attr($icon['class']) . '"></i>';
} elseif (is_string($icon) && !empty($icon)) {
	$icon_markup = $icon;
}

?>

<section class="w-full py-12 sm:py-16 lg:py-20">
	<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
		<div class="mb-8 flex flex-col gap-3">
			<span class="text-base font-medium uppercase tracking-[0.2em] text-slate-900 sm:text-lg">Featured</span>
			<span class="h-px w-full bg-slate-200"></span>
		</div>

		<div class="grid gap-6 lg:grid-cols-[1.3fr_1fr] lg:gap-8 xl:gap-10">
			<div class="overflow-hidden bg-slate-100 max-h-[400px]">
				<?php if ($image): ?>
					<img
						src="<?php echo esc_url(is_array($image) ? $image['url'] : $image); ?>"
						alt="<?php echo esc_attr(is_array($image) && !empty($image['alt']) ? $image['alt'] : $display_title); ?>"
						class="h-full w-full object-cover"
					/>
				<?php else: ?>
					<div class="flex aspect-[16/10] h-full min-h-[260px] items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 p-8">
						<?php if ($icon_markup): ?>
							<span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-white text-3xl text-slate-900 shadow-sm ring-1 ring-slate-200">
								<?php echo wp_kses_post($icon_markup); ?>
							</span>
						<?php else: ?>
							<span class="text-sm font-medium text-slate-500">Featured blog image</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="flex flex-col justify-center px-0 py-2 lg:px-2 xl:px-4">
				<?php if (!empty($display_title)): ?>
					<h2 class="text-3xl font-medium leading-tight tracking-tight text-slate-700 sm:text-4xl lg:text-[2.1rem] lg:leading-[1.15]">
						<?php echo esc_html($display_title); ?>
					</h2>
				<?php endif; ?>

				<?php if ($icon_markup || $date): ?>
					<div class="mt-6 flex items-center">
						<?php if ($icon_markup): ?>
							<span class="inline-flex shrink-0 text-2xl text-slate-700">
								<?php echo wp_kses_post($icon_markup); ?>
							</span>
						<?php endif; ?>
						<div class="min-w-0">
							<?php if ($subtext || $date): ?>
								<p class="text-sm text-slate-500">
									<?php if ($subtext): ?>
										<span class="font-medium"><?php echo esc_html($subtext); ?></span>
									<?php endif; ?>
									<?php if ($subtext && $date): ?>
										<span class="mx-2">•</span>
									<?php endif; ?>
									<?php if ($date): ?>
										<span><?php echo esc_html($date); ?></span>
									<?php endif; ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>