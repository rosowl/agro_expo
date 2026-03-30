<?php
$desktop_id = get_sub_field('hero_image_desktop');
$poster_id_desktop = get_sub_field('poster_desktop');
$mobile_id  = get_sub_field('hero_image_mobile');
$poster_id_mobile = get_sub_field('poster_mobile');
$poster_url_desktop = esc_url($poster_id_desktop ? wp_get_attachment_url($poster_id_desktop, '2k') : '');
$poster_url_mobile = esc_url($poster_id_mobile ? wp_get_attachment_url($poster_id_mobile, 'large') : '');
$desktop_is_video = false;
$desktop_url = '';
$desktop_mime = '';
$mobile_is_video = false;
$mobile_url = '';
$mobile_mime = '';

if (! empty($desktop_id)) {
	$desktop_mime = get_post_mime_type($desktop_id);
	if ($desktop_mime && strpos($desktop_mime, 'video/') === 0) {
		$desktop_is_video = true;
		$desktop_url = wp_get_attachment_url($desktop_id);
	} else {
		$desktop_url = wp_get_attachment_image_url($desktop_id, '2k');
	}
}

if (! empty($mobile_id)) {
	$mobile_mime = get_post_mime_type($mobile_id);
	if ($mobile_mime && strpos($mobile_mime, 'video/') === 0) {
		$mobile_is_video = true;
		$mobile_url = wp_get_attachment_url($mobile_id);
	} else {
		$mobile_url = wp_get_attachment_image_url($mobile_id, 'large');
	}
}

$btn_1_text = get_sub_field('button_1_text') ?: '';
$btn_1_link = get_sub_field('button_1_link') ?: '';
$btn_2_text = get_sub_field('button_2_text') ?: '';
$btn_2_link = get_sub_field('button_2_link') ?: '';
$phone      = get_sub_field('phone') ?: '';
$phone_url  = preg_replace('/[^0-9]/', '', $phone);
$section_id = get_query_var('section_id');
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--hero_banner<?php echo ($desktop_is_video || $mobile_is_video) ? ' section--hero_banner--video' : ''; ?>"
	<?php if (! $desktop_is_video && $desktop_url): ?>style="background-image:url('<?php echo esc_url($desktop_url); ?>');"
	<?php endif; ?>>
	<?php if ($desktop_is_video && $desktop_url): ?>
		<video class="hero-banner-video hero-banner-video--desktop" autoplay muted loop playsinline preload="metadata" poster="<?php echo $poster_url_desktop; ?>">
			<source src="<?php echo esc_url($desktop_url); ?>" type="<?php echo esc_attr($desktop_mime ?: 'video/mp4'); ?>">
			<?php echo esc_html__('Your browser does not support the video tag.', 'blankslate'); ?>
		</video>
	<?php endif; ?>
	<?php if ($mobile_is_video && $mobile_url): ?>
		<video class="hero-banner-video hero-banner-video--mobile" autoplay muted loop playsinline preload="metadata" poster="<?php echo $poster_url_mobile; ?>">
			<source src="<?php echo esc_url($mobile_url); ?>" type="<?php echo esc_attr($mobile_mime ?: 'video/mp4'); ?>">
			<?php echo esc_html__('Your browser does not support the video tag.', 'blankslate'); ?>
		</video>
	<?php endif; ?>
	<?php if (! $mobile_is_video && $mobile_url): ?>
		<style>
			@media (max-width: 767px) {
				.section--hero_banner {
					background-image: url('<?php echo esc_url($mobile_url); ?>') !important;
				}
			}
		</style>
	<?php endif; ?>
	<div class="w-full hero__inner">
		<div class="hero__content hero__content--left owl" data-animation="slideInLeft">

			<?php if ($btn_1_text && $btn_1_link): ?>
				<?php
				// decide if link should open modal: shortcode or Google form
				$href1 = '';
				if (strpos(ltrim($btn_1_link), '[') === 0) {
					$modal_id = 'modal-' . uniqid();
					echo '<div id="' . esc_attr($modal_id) . '" class="dialog-content" style="display:none;">' . do_shortcode($btn_1_link) . '</div>';
					$href1 = '#' . $modal_id;
				} elseif (preg_match('/docs\.google\.com\/forms/', $btn_1_link)) {
					$modal_id = 'modal-' . uniqid();
					echo '<div id="' . esc_attr($modal_id) . '" class="dialog-content" style="display:none;"><iframe class="modal-iframe" src="' . esc_url($btn_1_link) . '" frameborder="0" allowfullscreen></iframe></div>';
					$href1 = '#' . $modal_id;
				} else {
					$href1 = esc_url($btn_1_link);
				}
				?>
				<a class="hero__button" href="<?php echo esc_attr($href1); ?>"><?php echo esc_html($btn_1_text); ?></a>
			<?php endif; ?>
			<?php if ($btn_2_text && $btn_2_link): ?>
				<?php
				$href2 = '';
				if (strpos(ltrim($btn_2_link), '[') === 0) {
					$modal_id = 'modal-' . uniqid();
					echo '<div id="' . esc_attr($modal_id) . '" class="dialog-content" style="display:none;">' . do_shortcode($btn_2_link) . '</div>';
					$href2 = '#' . $modal_id;
				} elseif (preg_match('/docs\.google\.com\/forms/', $btn_2_link)) {
					$modal_id = 'modal-' . uniqid();
					echo '<div id="' . esc_attr($modal_id) . '" class="dialog-content" style="display:none;"><iframe class="modal-iframe" src="' . esc_url($btn_2_link) . '" frameborder="0" allowfullscreen></iframe></div>';
					$href2 = '#' . $modal_id;
				} else {
					$href2 = esc_url($btn_2_link);
				}
				?>
				<a class="hero__button" href="<?php echo esc_attr($href2); ?>"><?php echo esc_html($btn_2_text); ?></a>
			<?php endif; ?>
		</div>

		<div class="hero__content hero__content--right owl" data-animation="fadeInRight">
			<a class="link" href="tel:<?php echo esc_attr($phone_url); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 100 100" width="36" height="36">
					<path fill="var(--white-color)"
						d="m90.1 75.1-.5-1c-1.4-3.3-18.6-8.3-20-8.4l-1.1.1c-2.1.4-4.4 2.3-8.9 6.2-.9.8-2.1 1-3.2.4-5.9-3.3-13.1-9.9-16.7-13.9-3.9-4.3-8.6-11.4-10.8-17.1a3 3 0 0 1 .8-3.1c5.1-4.6 7.3-6.8 7.5-9.2.1-1.4-2.9-19.1-6-20.8l-.9-.6c-2-1.3-5-3.2-8.3-2.5-.8.2-1.6.5-2.3.9-2.2 1.4-7.7 5.2-10.2 10.1C8 19.3 7.3 47.4 28.3 71.1c20.8 23.5 46.5 24.5 50.3 23.7h.1l.3-.1c5.2-1.9 9.6-6.8 11.3-8.9 3.1-3.7 1-8.2-.2-10.7">
					</path>
				</svg>
				<span><?php echo esc_html($phone); ?></span></a>
		</div>

	</div>
</section>