<?php
$section_slope   = agro_get_sub_field('section_slope') ?: '';
$galleries_title = get_sub_field('galleries_title') ?: '';
$section_id      = get_query_var('section_id');

?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--galleries <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>">
	<div class="container">
		<?php if ($galleries_title): ?>
			<div class="title owl" data-animation="fadeInDown"><?php echo wp_kses_post($galleries_title); ?></div>
		<?php endif; ?>
		<?php if (have_rows('gallery')): ?>
			<div class="galleries">
				<?php
				$gallery_index = 0;
				while (have_rows('gallery')): the_row();
					$gallery_title = get_sub_field('gallery_title') ?: '';
					$images       = get_sub_field('images');
					$gallery_id   = 'gallery-' . $section_id . '-' . $gallery_index;
					$gallery_index++;
				?>
					<div class="gallery owl" <?php if ($gallery_index % 2 === 1):
																			echo 'data-animation="slideInLeft"';
																		else:
																			echo 'data-animation="slideInRight"';
																		endif;
																		?>>
						<?php if ($gallery_title): ?>
							<h3 class="gallery__title"><?php echo esc_html($gallery_title); ?></h3>
						<?php endif; ?>
						<?php if ($images): ?>
							<div class="splide gallery__splide" id="<?php echo esc_attr($gallery_id); ?>">
								<div class="splide__track">
									<ul class="splide__list gallery__images">
										<?php foreach ($images as $image_id): ?>
											<?php
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
											$image_url = wp_get_attachment_image_url($image_id, '2k');
											$image_large = wp_get_attachment_image_url($image_id, 'medium_large');
											?>
											<?php if ($image_url): ?>
												<li class="splide__slide gallery__slide">
													<div class="gallery__image-wrapper">
														<a href="<?php echo esc_url($image_url); ?>" data-fslightbox="<?php echo esc_attr($gallery_id); ?>"
															data-alt="<?php echo esc_attr($image_alt); ?>" class="gallery__image-link">
															<img src="<?php echo esc_url($image_large); ?>" loading="lazy"
																alt="<?php echo esc_attr($image_alt); ?>" class="gallery__image">
														</a>
													</div>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<!-- Thumbnails -->
							<div class="splide gallery__thumbnails" id="<?php echo esc_attr($gallery_id); ?>-thumbnails">
								<div class="splide__track">
									<ul class="splide__list gallery__thumbnails-list">
										<?php foreach ($images as $image_id): ?>
											<?php
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
											$image_thumb = wp_get_attachment_image_url($image_id, 'thumbnail');
											?>
											<?php if ($image_thumb): ?>
												<li class="splide__slide gallery__thumbnail-slide">
													<img src="<?php echo esc_url($image_thumb); ?>" loading="lazy" alt="<?php echo esc_attr($image_alt); ?>"
														class="gallery__thumbnail">
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>