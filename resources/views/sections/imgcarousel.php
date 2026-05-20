<?php

if (!function_exists('vu_imgcarousel_slides')) {
	function vu_imgcarousel_slides($items): array
	{
		if (empty($items)) {
			return [];
		}

		$rows = (is_array($items) && isset($items[0])) ? $items : [$items];

		$slides = [];

		foreach ($rows as $row) {
			$image = [];
			$link  = null;

			if (is_array($row) && isset($row['image'])) {
				$image = is_array($row['image'])
					? $row['image']
					: ['url' => (string) $row['image']];
				$link = $row['link'] ?? null;
			} elseif (is_array($row)) {
				$image = $row;
				$link  = $row['link'] ?? null;
			} elseif (is_numeric($row)) {
				$attachment_id = (int) $row;
				$src           = wp_get_attachment_image_src($attachment_id, 'large');

				if ($src) {
					$image = [
						'url'    => $src[0],
						'width'  => $src[1],
						'height' => $src[2],
						'alt'    => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
					];
				}
			} else {
				$image = ['url' => (string) $row];
			}

			if (empty($image['url'])) {
				continue;
			}

			$slides[] = [
				'url'    => (string) $image['url'],
				'alt'    => (string) ($image['alt'] ?? ''),
				'w'      => (int) ($image['width'] ?? 0),
				'h'      => (int) ($image['height'] ?? 0),
				'href'   => is_array($link) ? (string) ($link['url'] ?? '') : (is_string($link) ? $link : ''),
				'target' => is_array($link) ? (string) ($link['target'] ?? '') : '',
			];
		}

		return $slides;
	}
}

$titel  = get_sub_field('titel');
$button = get_sub_field('button');
$slides = vu_imgcarousel_slides(get_sub_field('images'));

if (empty($slides)) {
	return;
}

$total       = count($slides);
$has_nav     = $total > 1;
$carousel_id = wp_unique_id('imgcarousel-');
$first_slide = $slides[0];

$ratio = ($first_slide['w'] > 0 && $first_slide['h'] > 0)
	? $first_slide['w'] . ' / ' . $first_slide['h']
	: '16 / 9';

$arrow_classes = 'imgcarousel__arrow flex items-center justify-center rounded-base border-[2px] border-primary text-primary bg-white transition hover:bg-primary hover:text-white';
?>

<section class="px-4 py-10 md:py-14">
	<div class="container mx-auto">

		<?php if ($titel) : ?>
			<h2 class="text-center font-sans text-2xl md:text-4xl font-bold text-accent mb-8 md:mb-10"><?php echo esc_html($titel); ?></h2>
		<?php endif; ?>

		<div id="<?php echo esc_attr($carousel_id); ?>" class="imgcarousel relative" style="--imgc-ratio: <?php echo esc_attr($ratio); ?>;">

			<div class="flex items-center justify-center gap-3 sm:gap-4 md:gap-8">

				<?php if ($has_nav) : ?>
					<button type="button" class="carousel-prev <?php echo esc_attr($arrow_classes); ?>" aria-label="Vorige afbeelding" aria-controls="<?php echo esc_attr($carousel_id); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-5 h-5 md:w-7 md:h-7" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
						</svg>
					</button>
				<?php endif; ?>

				<div class="carousel-viewport relative w-full rounded-base overflow-hidden max-h-[300px]">
					<?php foreach ($slides as $i => $slide) :
						$is_active = 0 === $i;
						$has_link  = !empty($slide['href']);
					?>
						<div class="carousel-slide w-full h-full <?php echo $is_active ? ' is-active' : ''; ?>"
							aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
							<?php if ($has_link) : ?>href="<?php echo esc_url($slide['href']); ?>"<?php endif; ?>
							<?php if (!empty($slide['target'])) : ?>target="<?php echo esc_attr($slide['target']); ?>"<?php endif; ?>>
							<img class="w-full h-full !object-cover" src="<?php echo esc_url($slide['url']); ?>"
								alt="<?php echo esc_attr($slide['alt']); ?>"
								<?php if ($slide['w'] && $slide['h']) : ?>width="<?php echo (int) $slide['w']; ?>" height="<?php echo (int) $slide['h']; ?>"<?php endif; ?>
								loading="<?php echo $is_active ? 'eager' : 'lazy'; ?>"
								decoding="async">
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ($has_nav) : ?>
					<button type="button" class="carousel-next <?php echo esc_attr($arrow_classes); ?>" aria-label="Volgende afbeelding" aria-controls="<?php echo esc_attr($carousel_id); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-5 h-5 md:w-7 md:h-7" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
						</svg>
					</button>
				<?php endif; ?>
			</div>

			<?php if ($has_nav) : ?>
				<div class="carousel-dots flex flex-wrap items-center justify-center gap-2 sm:gap-3 md:gap-4 mt-6 md:mt-8" role="tablist" aria-label="Kies een afbeelding">
					<?php foreach ($slides as $i => $slide) :
						$is_active = 0 === $i;
					?>
						<button type="button" role="tab"
								class="carousel-dot<?php echo $is_active ? ' is-active' : ''; ?>"
								data-index="<?php echo (int) $i; ?>"
								aria-label="Afbeelding <?php echo (int) $i + 1; ?> van <?php echo (int) $total; ?>"
								aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
							<img src="<?php echo esc_url($slide['url']); ?>" alt="" loading="lazy" decoding="async">
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ($button && !empty($button['url'])) : ?>
				<div class="mt-8 md:mt-10 flex justify-center">
					<a class="btn btn-primary w-fit" href="<?php echo esc_url($button['url']); ?>"<?php if (!empty($button['target'])) : ?> target="<?php echo esc_attr($button['target']); ?>"<?php endif; ?>>
						<?php echo esc_html($button['title']); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php // CSS zodat de carrousel ook zonder Tailwind-build werkt. #00B6CB = thema 'primary', #ABE0E6 = 'primary_light', #F3F3F3 ?>
<style>
	#<?php echo $carousel_id; ?> .imgcarousel__arrow {
		flex: 0 0 auto;
		width: 40px; height: 44px;
		box-shadow: 0 1px 3px rgba(16, 25, 53, .12);
	}
	#<?php echo $carousel_id; ?> .imgcarousel__arrow:hover { box-shadow: 0 4px 12px rgba(0, 182, 203, .35); }
	#<?php echo $carousel_id; ?> .imgcarousel__arrow:focus-visible { outline: 2px solid #00B6CB; outline-offset: 2px; }

	#<?php echo $carousel_id; ?> .carousel-viewport {
		max-width: 700px;
		margin-inline: auto;
		aspect-ratio: var(--imgc-ratio, 16 / 9);
		background-color: #F3F3F3;
		box-shadow: 0 12px 30px rgba(16, 25, 53, .14);
	}
	#<?php echo $carousel_id; ?> .carousel-slide {
		position: absolute; inset: 0;
		opacity: 0; pointer-events: none;
		transition: opacity .6s ease-in-out;
	}
	#<?php echo $carousel_id; ?> .carousel-slide.is-active { opacity: 1; pointer-events: auto; }
	#<?php echo $carousel_id; ?> .carousel-slide img { width: 100%; height: 100%; object-fit: contain; display: block; }

	#<?php echo $carousel_id; ?> .carousel-dot {
		flex: 0 0 auto;
		width: 44px; height: 48px;
		border-radius: 12px;
		overflow: hidden;
		border: 2px solid transparent;
		opacity: .5;
		background-color: #F3F3F3;
		transition: opacity .25s ease, transform .25s ease, box-shadow .25s ease;
	}
	#<?php echo $carousel_id; ?> .carousel-dot img { width: 100%; height: 100%; object-fit: cover; display: block; }
	#<?php echo $carousel_id; ?> .carousel-dot:hover,
	#<?php echo $carousel_id; ?> .carousel-dot:focus-visible { opacity: 1; outline: none; box-shadow: 0 0 0 2px #ABE0E6; }
	#<?php echo $carousel_id; ?> .carousel-dot.is-active { opacity: 1; box-shadow: 0 0 0 3px #00B6CB; transform: scale(1.06); }

	@media (min-width: 640px) {
		#<?php echo $carousel_id; ?> .imgcarousel__arrow { width: 44px; height: 48px; }
		#<?php echo $carousel_id; ?> .carousel-dot { width: 48px; height: 52px; }
	}
	@media (min-width: 768px) {
		#<?php echo $carousel_id; ?> .imgcarousel__arrow { width: 52px; height: 56px; }
		#<?php echo $carousel_id; ?> .carousel-dot { width: 56px; height: 60px; }
	}
	@media (prefers-reduced-motion: reduce) {
		#<?php echo $carousel_id; ?> .carousel-slide,
		#<?php echo $carousel_id; ?> .carousel-dot { transition: none; }
	}
</style>