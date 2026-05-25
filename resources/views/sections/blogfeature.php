<?php
// Fetch the most recent published blog post
$recent_posts = get_posts([
	'post_type'      => 'post',
	'posts_per_page' => 1,
	'post_status'    => 'publish',
]);

if (empty($recent_posts)) {
	return;
}

$post          = $recent_posts[0];
$post_id       = $post->ID;
$display_title = get_the_title($post_id);
$date          = get_the_date(get_option('date_format'), $post_id);
$permalink     = get_permalink($post_id);
$subtext       = wp_strip_all_tags(get_the_excerpt($post_id));

// WordPress featured image (post thumbnail)
$has_image = has_post_thumbnail($post_id);
$image_url = $has_image ? get_the_post_thumbnail_url($post_id, 'large') : '';
$image_alt = $has_image
	? (get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true) ?: $display_title)
	: $display_title;

// ACF icon field on the post (optional)
$icon        = function_exists('get_field') ? (get_field('icon', $post_id) ?: '') : '';
$icon_markup = '';
if (is_object($icon) && !empty($icon->element)) {
	$icon_markup = $icon->element;
} elseif (is_array($icon) && !empty($icon['element'])) {
	$icon_markup = $icon['element'];
} elseif (is_array($icon) && !empty($icon['class'])) {
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
				<?php if ($has_image): ?>
					<a href="<?php echo esc_url($permalink); ?>">
						<img
							src="<?php echo esc_url($image_url); ?>"
							alt="<?php echo esc_attr($image_alt); ?>"
							class="h-full w-full object-cover"
						/>
					</a>
				<?php else: ?>
					<div class="flex aspect-[16/10] h-full min-h-[260px] items-center justify-center p-8 text-white/90" style="background-image: linear-gradient(90deg,#00b6cb 62%,#101935 100%);">
						<?php if ($icon_markup): ?>
							<span class="inline-flex text-3xl">
								<?php echo wp_kses_post($icon_markup); ?>
							</span>
						<?php else: ?>
							<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
							</svg>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="flex flex-col justify-center px-0 py-2 lg:px-2 xl:px-4">
				<?php if (!empty($display_title)): ?>
					<h2 class="text-3xl font-medium leading-tight tracking-tight text-slate-700 sm:text-4xl lg:text-[2.1rem] lg:leading-[1.15]">
						<a href="<?php echo esc_url($permalink); ?>" class="hover:underline">
							<?php echo esc_html($display_title); ?>
						</a>
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