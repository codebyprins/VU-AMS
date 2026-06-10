<?php
$button_value = get_sub_field('button');

$file_id = 0;
$file_url = '';
$file_mime = '';

if (is_numeric($button_value)) {
	$file_id = (int) $button_value;
} elseif (is_array($button_value)) {
	$file_id = !empty($button_value['ID']) ? (int) $button_value['ID'] : 0;
	$file_url = !empty($button_value['url']) ? $button_value['url'] : '';
	$file_mime = !empty($button_value['mime_type']) ? $button_value['mime_type'] : '';
} elseif (is_object($button_value)) {
	$file_id = !empty($button_value->ID) ? (int) $button_value->ID : 0;
	$file_url = !empty($button_value->url) ? $button_value->url : '';
	$file_mime = !empty($button_value->mime_type) ? $button_value->mime_type : '';
} elseif (is_string($button_value)) {
	$file_url = trim($button_value);
}

if ($file_id && !$file_url) {
	$file_url = wp_get_attachment_url($file_id);
}

if ($file_id && !$file_mime) {
	$file_mime = get_post_mime_type($file_id) ?: '';
}

if (!$file_url) {
	$post_id = get_the_ID();
	$file_url = get_post_meta($post_id, 'source_url', true) ?: get_post_meta($post_id, 'publication_url', true);
	if (!$file_mime && $file_url) {
		$file_mime = wp_check_filetype($file_url)['type'] ?? '';
	}
}

if (!$file_url) {
	return;
}

$download_name = '';
$file_path = wp_parse_url($file_url, PHP_URL_PATH);
if ($file_path) {
	$download_name = basename($file_path);
}
if ($download_name === '') {
	$download_name = 'download.pdf';
}

$is_image = $file_mime && strpos($file_mime, 'image/') === 0;
?>
<section class="w-full bg-[#f8f8f8] py-section_base">
	<div class="mx-auto max-w-7xl px-container_xs sm:px-container_sm lg:px-container_lg">
		<div class="mx-auto max-w-3xl overflow-hidden rounded-base border border-accent/10 bg-white">
			<div class="hidden sm:block border-b border-accent/10 bg-surface p-6 sm:p-8">
				<?php if ($is_image): ?>
					<img
						src="<?php echo esc_url($file_url); ?>"
						alt="PDF preview"
						class="h-[500px] w-full rounded-base object-cover"
					/>
				<?php else: ?>
					<iframe
						src="<?php echo esc_url($file_url); ?>#view=FitH"
						title="PDF preview"
						class="h-[500px] w-full border-0"
						loading="lazy"
					></iframe>
				<?php endif; ?>
			</div>

			<div class="flex flex-col gap-4 p-6 sm:p-8">
				<p class="max-w-[65ch] text-base leading-7 text-accent/80">De knop start een directe download en bewaart de bestandsnaam.</p>
				<a
					href="<?php echo esc_url($file_url); ?>"
					download="<?php echo esc_attr($download_name); ?>"
					class="inline-flex w-fit items-center justify-center rounded-base bg-primary px-6 py-3.5 text-base font-medium text-white transition hover:bg-primary_dark"
				>
					Download PDF
				</a>
			</div>
		</div>
	</div>
</section>
