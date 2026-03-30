<?php
$section_id  = get_query_var('section_id');
$maket_title = get_sub_field('maket_title') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="section section--partners">
	<?php if ($maket_title): ?>
		<div class="container">
			<h2 class="title"><?php echo esc_html($maket_title); ?></h2>
		</div>
	<?php endif; ?>

	<?php if (have_rows('partner_types')):
		$row_count = 0;
	?>
		<?php while (have_rows('partner_types')): the_row();
			$row_count++;
		?>
			<?php $layout = get_row_layout(); ?>

			<!-- Partner General: Full Width Background -->
			<?php if ($layout == 'partner_general'): ?>
				<?php
				$section_slope = agro_get_sub_field('section_slope') ?: '';
				$background_id  = get_sub_field('background');
				$background_url_mobile = $background_id ? wp_get_attachment_image_url($background_id, 'medium_large') : '';
				$background_url_desktop = $background_id ? wp_get_attachment_image_url($background_id, '2k') : '';
				$title       = get_sub_field('title') ?: '';
				$logo_id     = get_sub_field('logo');
				$logo_url 	 = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium_large') : '';
				$name        = get_sub_field('name') ?: '';
				$text        = get_sub_field('text') ?: '';
				$button_text = get_sub_field('button_text') ?: '';
				$button_link = get_sub_field('button_link') ?: '';
				?>
				<div class="partner-general section <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>"
					<?php if ($background_url_mobile || $background_url_desktop): ?>
					data-bg-url-mobile="<?php echo esc_url($background_url_mobile); ?>" data-bg-url-desktop="<?php echo esc_url($background_url_desktop); ?>"
					<?php endif; ?>>
					<!-- Overlay -->
					<div class="partner-general__overlay"></div>

					<!-- Content Block -->
					<div class="container">
						<div class="partner-general__content owl" data-animation="slideInRight">
							<?php if ($title): ?>
								<h3 class="partner-general__subtitle"><?php echo esc_html($title); ?></h3>
							<?php endif; ?>

							<?php if ($logo_url): ?>
								<div class="partner-general__logo-wrapper">
									<img class="partner-general__logo" src="<?php echo esc_url($logo_url); ?>"
										alt="<?php echo esc_attr($name ?: $logo['alt']); ?>" loading="lazy">
								</div>
							<?php endif; ?>

							<?php if ($name): ?>
								<p class="partner-general__name"><?php echo esc_html($name); ?></p>
							<?php endif; ?>

							<?php if ($text): ?>
								<div class="partner-general__text"><?php echo wp_kses_post($text); ?></div>
							<?php endif; ?>

							<?php if ($button_text && $button_link): ?>
								<a class="btn btn--brand" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>

			<?php endif; ?>

			<!-- Partner Main: Row Layout in Container -->
			<?php if ($layout == 'partner_main'): ?>
				<?php
				$title       = get_sub_field('title') ?: '';
				$logo_id     = get_sub_field('logo');
				$logo_url 	 = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium_large') : '';
				$name        = get_sub_field('name') ?: '';
				$text        = get_sub_field('text') ?: '';
				$button_text = get_sub_field('button_text') ?: '';
				$button_link = get_sub_field('button_link') ?: '';
				?>
				<div class="container">
					<!-- Check if not first row and odd row -->
					<?php if ($row_count != 1 && $row_count % 2 != 0): ?>
						<hr class="partner-main__separator">
					<?php endif; ?>

					<div class="partner-main owl" data-animation="slideInUp">
						<!-- Logo Column -->
						<?php if ($logo_url): ?>
							<div class="partner-main__logo-col">
								<img class="partner-main__logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($name); ?>"
									loading="lazy">
							</div>
						<?php endif; ?>

						<!-- Content Column -->
						<div class="partner-main__content-col">
							<?php if ($title): ?>
								<h3 class="partner-main__title"><?php echo esc_html($title); ?></h3>
							<?php endif; ?>

							<?php if ($text): ?>
								<div class="partner-main__text"><?php echo wp_kses_post($text); ?></div>
							<?php endif; ?>

							<?php if ($button_text && $button_link): ?>
								<a class="btn btn--secondary"
									href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
							<?php endif; ?>
						</div>
					</div>

				</div>
			<?php endif; ?>

			<!-- Partner Others: Flex Columns -->
			<?php if ($layout == 'partner_others'): ?>
				<?php
				$partners_list = get_sub_field('partner') ?: [];
				?>
				<?php if ($partners_list && have_rows('partner')): ?>
					<div class="container">
						<div class="partner-others owl" data-animation="slideInLeft">
							<?php while (have_rows('partner')): the_row(); ?>
								<?php
								$partner_name = get_sub_field('name') ?: '';
								$partner_text = get_sub_field('text') ?: '';
								$partner_link = get_sub_field('link') ?: '';
								$logo_id     = get_sub_field('logo');
								$logo_url 	 = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium_large') : '';

								?>
								<?php if ($partner_link): ?>
									<a href="<?php echo esc_url($partner_link); ?>" class="partner-other">
										<?php if ($logo_url): ?>
											<div class="partner-other__logo-wrapper">
												<img class="partner-other__logo" src="<?php echo esc_url($logo_url); ?>"
													alt="<?php echo esc_attr($partner_name); ?>" loading="lazy">
											</div>
										<?php endif; ?>
										<?php if ($partner_text): ?>
											<div class="partner-other__text"><?php echo wp_kses_post($partner_text); ?></div>
										<?php endif; ?>
									</a>
								<?php else: ?>
									<div class="partner-other partner-other--no-link">
										<?php if ($logo_url): ?>
											<div class="partner-other__logo-wrapper">
												<img class="partner-other__logo" src="<?php echo esc_url($logo_url); ?>"
													alt="<?php echo esc_attr($partner_name); ?>" loading="lazy">
											</div>
										<?php endif; ?>
										<?php if ($partner_text): ?>
											<div class="partner-other__text"><?php echo wp_kses_post($partner_text); ?></div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		<?php endwhile; ?>
	<?php endif; ?>
</section>