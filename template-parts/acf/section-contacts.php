<?php
$section_id    = get_query_var('section_id');
$section_slope = agro_get_sub_field('section_slope') ?: '';
$title         = get_sub_field('title') ?: '';
$address       = get_sub_field('address') ?: '';
$phone         = get_sub_field('phone') ?: '';
$phone_url  	 = preg_replace('/[^0-9]/', '', $phone);
$email         = get_sub_field('email') ?: '';
$button_text   = get_sub_field('button_text') ?: '';
$button_link   = get_sub_field('button_link') ?: '';
$show_social   = get_sub_field('show_social');
$map           = get_sub_field('map');
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--contacts <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>">
	<div class="container contacts">
		<div class="contacts__info owl" data-animation="slideInLeft">

			<?php if ($title): ?>
			<h2 class="title contacts__title"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>

			<?php if ($address): ?>
			<p class="contacts__address">
				<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 100 100" width="20" height="20">
					<path fill="var(--brand-color)"
						d="M50 0a33.87 33.87 0 0 0-31.9 45.26C25.32 69.02 50 100 50 100s24.67-30.98 31.9-54.73a34 34 0 0 0 1.97-11.4A33.87 33.87 0 0 0 50 0m0 50.46a16.59 16.59 0 1 1 0-33.18 16.59 16.59 0 0 1 0 33.18" />
				</svg>
				<?php echo nl2br(esc_html($address)); ?>
			</p>
			<?php endif; ?>
			<?php if ($phone): ?>
			<p class="contacts__phone">
				<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 100 100" width="24" height="24">
					<path fill="var(--brand-color)"
						d="m90.1 75.1-.5-1c-1.4-3.3-18.6-8.3-20-8.4l-1.1.1c-2.1.4-4.4 2.3-8.9 6.2-.9.8-2.1 1-3.2.4-5.9-3.3-13.1-9.9-16.7-13.9-3.9-4.3-8.6-11.4-10.8-17.1a3 3 0 0 1 .8-3.1c5.1-4.6 7.3-6.8 7.5-9.2.1-1.4-2.9-19.1-6-20.8l-.9-.6c-2-1.3-5-3.2-8.3-2.5-.8.2-1.6.5-2.3.9-2.2 1.4-7.7 5.2-10.2 10.1C8 19.3 7.3 47.4 28.3 71.1c20.8 23.5 46.5 24.5 50.3 23.7h.1l.3-.1c5.2-1.9 9.6-6.8 11.3-8.9 3.1-3.7 1-8.2-.2-10.7" />
				</svg>
				<a href="tel:<?php echo esc_attr($phone_url); ?>"><?php echo esc_html($phone); ?></a>
			</p>
			<?php endif; ?>
			<?php if ($email): ?>
			<p class="contacts__email"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
			</p>
			<?php endif; ?>
			<?php if ($button_text && $button_link): ?>
			<?php
				$button_href = '';
				if (strpos(ltrim($button_link), '[') === 0) {
					$modal_id = 'modal-' . uniqid();
					echo '<div id="' . esc_attr($modal_id) . '" class="dialog-content" style="display:none;">' . do_shortcode($button_link) . '</div>';
					$button_href = '#' . $modal_id;
				} elseif (preg_match('/docs\.google\.com\/forms/', $button_link)) {
					$modal_id = 'modal-' . uniqid();
					echo '<div id="' . esc_attr($modal_id) . '" class="dialog-content" style="display:none;"><iframe class="modal-iframe" src="' . esc_url($button_link) . '" frameborder="0" allowfullscreen></iframe></div>';
					$button_href = '#' . $modal_id;
				} else {
					$button_href = esc_url($button_link);
				}
				?>
			<p class="contacts__button"><a href="<?php echo esc_attr($button_href); ?>"
					class="btn btn--secondary"><?php echo esc_html($button_text); ?></a></p>
			<?php endif; ?>

			<?php if ($show_social): ?>
			<div class="contacts__social">
				<?php
					$socials = agro_get_social_links();
					foreach ($socials as $key => $social) {
						if (! empty($social['url'])) {
							echo '<a href="' . esc_url($social['url']) . '" class="social-link social-' . esc_attr($key) . '" title="' . esc_attr($social['label']) . '" target="_blank" rel="noopener noreferrer">';
							echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/media/' . $social['icon']) . '" alt="' . esc_attr($social['label']) . '" class="social-icon" loading="lazy" />';
							echo '</a>';
						}
					}
					?>
			</div>
			<?php endif; ?>
		</div>

		<?php if ($map): ?>
		<div class="contacts__map owl" data-animation="slideInRight"><?php echo $map; ?></div>
		<?php endif; ?>
	</div>
</section>