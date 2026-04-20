<?php
$title = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
$content = get_sub_field('content');
$alignment = get_sub_field('position');

if (! in_array($alignment, ['left', 'center', 'right'], true)) {
	$alignment = 'center';
}

$alignment_classes = [
	'left' => 'text-left items-start',
	'center' => 'text-center items-center',
	'right' => 'text-right items-end',
];

$content_alignment_class = $alignment_classes[$alignment];
?>

<section class="bg-[#F8F8F8] py-10">
	<div class="container mx-auto px-4 flex flex-col gap-3 md:gap-5 <?php echo esc_attr($content_alignment_class); ?>">
		<?php if ($title) : ?>
			<h2 class="text-2xl md:text-4xl font-bold"><?php echo esc_html($title); ?></h2>
		<?php endif; ?>

		<?php if ($subtitle) : ?>
			<p class="text-lg md:text-xl text-accent/80"><?php echo esc_html($subtitle); ?></p>
		<?php endif; ?>

		<?php if ($content) : ?>
			<div class="max-w-[600px]"><?php echo wp_kses_post($content); ?></div>
		<?php endif; ?>
	</div>
</section>