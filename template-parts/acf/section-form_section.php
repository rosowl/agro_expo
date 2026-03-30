<?php
$section_id       = get_query_var('section_id');
$section_slope    = agro_get_sub_field('section_slope') ?: '';
$image_id         = get_sub_field('image');
$image_url_mobile = $image_id ? wp_get_attachment_image_url($image_id, 'medium_large') : '';
$image_url_desktop = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
$text             = get_sub_field('text') ?: '';
$form_shortcode   = get_sub_field('form_shortcode') ?: '';
$background_color = get_sub_field('background_color') ?: '#000000';
$text_color       = get_sub_field('text_color') ?: '#ffffff';
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--form_section <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>"
	style="background-color: <?php echo esc_attr($background_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
	<div class="form-section">
		<?php if ($image_url_mobile || $image_url_desktop): ?>
		<img class="form-section__image owl" data-animation="slideInLeft" src="<?php echo esc_url($image_url_desktop); ?>"
			srcset="<?php echo esc_url($image_url_mobile); ?> 768w, <?php echo esc_url($image_url_desktop); ?> 1024w"
			sizes="(max-width: 768px) 100vw, 1024px"
			alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)); ?>" loading="lazy">
		<?php endif; ?>
		<?php if ($text || $form_shortcode): ?>
		<div class="form-section__content">
			<?php if ($text): ?>
			<div class="form-section__text owl" data-animation="fadeInDown"><?php echo wp_kses_post($text); ?></div>
			<?php endif; ?>
			<?php if ($form_shortcode): ?>
			<div class="form-section__wrapper owl" data-animation="fadeInUp"><?php echo do_shortcode($form_shortcode); ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</section>