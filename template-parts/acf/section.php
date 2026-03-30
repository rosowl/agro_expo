<?php
// Универсальная шаблонная часть для секции ACF
$section_data = isset($args) && is_array($args) ? $args : [];
$type         = isset($section_data['type']) ? $section_data['type'] : 'default';
$title        = isset($section_data['title']) ? $section_data['title'] : '';
$description  = isset($section_data['description']) ? $section_data['description'] : '';
$background   = isset($section_data['background']) ? $section_data['background'] : '';
$class        = $type;
$section_id   = get_query_var('section_id');
?>
<section id="<?php echo esc_attr($section_id); ?>" class="section section--<?php echo esc_attr($class); ?>"
	<?php if ($background): ?>style="background-image: url('<?php echo esc_url($background); ?>')" <?php endif; ?>>
	<div class="container">
		<?php if ($title): ?>
			<h2><?php echo esc_html($title); ?></h2>
		<?php endif; ?>
		<?php if ($description): ?>
			<p><?php echo wp_kses_post($description); ?></p>
		<?php endif; ?>
	</div>
</section>