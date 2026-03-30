<?php
$section_id       = get_query_var('section_id');
$section_slope    = agro_get_sub_field('section_slope') ?: '';
$background_id    = get_sub_field('background');
$background_url_mobile = $background_id ? wp_get_attachment_image_url($background_id, 'large') : '';
$background_url_desktop = $background_id ? wp_get_attachment_image_url($background_id, '2k') : '';
$height           = (int) get_sub_field('parallax_height') ?: 540;
$overlay          = get_sub_field('overlay') ?: 'rgba(13, 13, 13, 0.56)';
$title            = get_sub_field('title') ?: '';
$countdown_target = get_sub_field('show_countdown') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--parallax <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>"
	style="height: <?php echo $height ?>px;">
	<div class="parallax-bg" <?php if ($background_url_mobile || $background_url_desktop): ?>
		data-bg-url-mobile="<?php echo esc_url($background_url_mobile); ?>" data-bg-url-desktop="<?php echo esc_url($background_url_desktop); ?>"
		<?php endif; ?>>
	</div>
	<div class="parallax-overlay" style="background-color: <?php echo esc_attr($overlay); ?>;"></div>
	<div class="parallax-content owl">
		<?php if ($title): ?>
			<h2 class="parallax-title"><?php echo esc_html($title); ?></h2>
		<?php endif; ?>
		<?php if ($countdown_target): ?>
			<?php get_template_part('template-parts/components/countdown', null, ['target' => $countdown_target]); ?>
		<?php endif; ?>
	</div>
</section>