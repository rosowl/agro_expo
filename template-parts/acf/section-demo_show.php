<?php
$section_id    = get_query_var('section_id');
$section_slope = agro_get_sub_field('section_slope') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--demo_show <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>">
	<div class="container">
		<?php if (have_rows('block')): ?>
			<div class="demo_show__blocks owl" data-animation="slideInRight">
				<?php while (have_rows('block')): the_row(); ?>
					<?php
					$block_id	= get_row_index();
					$title = get_sub_field('block_title') ?: '';
					$text = get_sub_field('block_text') ?: '';
					$background_id = get_sub_field('block_background');
					if (! empty($background_id)) {
						$bg = wp_get_attachment_image_url($background_id, 'medium_large');
					}
					$bg_color = get_sub_field('block_background_color') ?: 'hsl(from var(--dark-background-color) h s l / 0.75)';
					$link     = get_sub_field('block_link') ?: '';
					$btn_text = get_sub_field('block_button_text') ?: '';
					?>
					<div class="demo_show__block" id="demo_show__block-<?php echo $block_id; ?>">
						<style>
							#demo_show__block-<?php echo $block_id;

																?>:after {
								background: <?php echo $bg_color;
														?>;
							}
						</style>
						<?php if ($bg): ?>
							<picture class="demo_show__image">
								<img src="<?php echo esc_url($bg); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
							</picture>
						<?php endif; ?>
						<div class="demo_show__content">
							<?php if ($title): ?>
								<h3 class="demo_show__title"><?php echo esc_html($title); ?></h3>
							<?php endif; ?>
							<?php if ($text): ?>
								<div class="demo_show__text"><?php echo wp_kses_post($text); ?></div>
							<?php endif; ?>
							<?php if ($btn_text && $link): ?>
								<a class="btn btn--secondary" href="<?php echo esc_url($link); ?>"><?php echo esc_html($btn_text); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>