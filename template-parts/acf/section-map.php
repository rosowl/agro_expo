<?php
$section_id    = get_query_var('section_id');
$section_slope = agro_get_sub_field('section_slope') ?: '';
$image_id  = get_sub_field('map_image');
$image_url_mobile = $image_id ? wp_get_attachment_image_url($image_id, 'medium_large') : '';
$image_url_desktop = $image_id ? wp_get_attachment_image_url($image_id, '2k') : '';
$background    = get_sub_field('background') ?: '#8EC65B';
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--map <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>"
	style="background-color: <?php echo esc_attr($background); ?>;">
	<div class="container container--wide map owl" data-animation="slideInRight">
		<?php if ($image_url_mobile || $image_url_desktop): ?>
			<img class="map__image" src="<?php echo esc_url($image_url_desktop); ?>"
				srcset="<?php echo esc_url($image_url_mobile); ?> 768w, <?php echo esc_url($image_url_desktop); ?> 1024w"
				sizes="(max-width: 768px) 100vw, 1024px" alt="Map" loading="lazy" width="100%">
		<?php endif; ?>

	</div>
</section>