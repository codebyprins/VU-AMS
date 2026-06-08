<?php
$title = get_sub_field('title') ?: '';

$featured_posts = [];

$query = new WP_Query([
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
	'orderby' => 'date',
	'order' => 'DESC',
]);

if ($query->have_posts()) {
	while ($query->have_posts()) {
		$query->the_post();

		$post_id = get_the_ID();
		$featured_posts[] = [
			'title' => get_the_title(),
			'excerpt' => wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 14, '…'),
			'permalink' => get_permalink(),
			'date' => get_the_date(),
			'image_id' => get_post_thumbnail_id($post_id),
			'category' => '',
		];

		$categories = get_the_category();
		if (!empty($categories) && !is_wp_error($categories)) {
			$featured_posts[array_key_last($featured_posts)]['category'] = $categories[0]->name;
		}
	}

	wp_reset_postdata();
}

?>

<section class="w-full bg-[#F8F8F8] py-section_base">
	<div class="mx-auto max-w-7xl px-container_xs sm:px-container_sm lg:px-container_lg">
		<div class="max-w-[65ch]">
			<p class="text-sm font-medium uppercase tracking-[0.24em] text-accent/70"><?php echo esc_html($title); ?></p>
		</div>

		<?php if (!empty($featured_posts)): ?>
			<div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
				<?php foreach ($featured_posts as $post_item): ?>
					<article class="overflow-hidden rounded-base border border-accent/10 bg-white shadow-sm transition-transform duration-200 hover:-translate-y-1">
						<a class="block h-full" href="<?php echo esc_url($post_item['permalink']); ?>">
							<div class="bg-[#F8F8F8]">
								<?php if (!empty($post_item['image_id'])): ?>
									<?php echo wp_get_attachment_image($post_item['image_id'], 'large', false, ['class' => 'aspect-[16/10] h-full w-full object-cover']); ?>
								<?php else: ?>
									<div class="flex aspect-[16/10] items-center justify-center bg-primary-gradient px-6 py-12 text-center text-white">
										<span class="text-sm font-medium uppercase tracking-[0.2em]">Blog post</span>
									</div>
								<?php endif; ?>
							</div>

							<div class="flex h-full flex-col gap-4 p-6">
								<div class="flex flex-wrap items-center gap-3 text-sm text-accent/60">
									<span><?php echo esc_html($post_item['date']); ?></span>
									<?php if (!empty($post_item['category'])): ?>
										<span class="h-1 w-1 rounded-full bg-primary"></span>
										<span><?php echo esc_html($post_item['category']); ?></span>
									<?php endif; ?>
								</div>

								<h3 class="text-h4 font-normal leading-tight text-accent">
									<?php echo esc_html($post_item['title']); ?>
								</h3>

								<p class="max-w-[65ch] text-base leading-7 text-accent/80">
									<?php echo esc_html($post_item['excerpt']); ?>
								</p>
							</div>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>