<?php
$section_id           = get_query_var('section_id');
$section_slope        = agro_get_sub_field('section_slope') ?: '';
$projects_title       = get_sub_field('projects_title') ?: '';
$background           = get_sub_field('background') ?: '#0D0D0D';
$background_image_id  = get_sub_field('background_image');
$background_image_url = $background_image_id ? wp_get_attachment_image_url($background_image_id, '2k') : '';
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--team <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>"
	style="background-color: <?php echo esc_attr($background); ?>; <?php if ($background_image_url): ?>background-image: url('<?php echo esc_url($background_image_url); ?>'); background-position: 100% 100%; background-repeat: no-repeat;<?php endif; ?>">
	<div class="container team">
		<?php if ($projects_title): ?>
		<h2 class="title team__title"><?php echo esc_html($projects_title); ?></h2>
		<?php endif; ?>
		<?php if (have_rows('member')): ?>
		<div class="team__members">
			<?php while (have_rows('member')): the_row(); ?>
			<?php
					$block_id	 = get_row_index();
					$photo_id   = get_sub_field('photo');
					$photo_url = $photo_id ? wp_get_attachment_image_url($photo_id, 'medium_large') : '';
					$name      = get_sub_field('name') ?: '';
					$position  = get_sub_field('position') ?: '';
					$email     = get_sub_field('email') ?: '';
					?>
			<div class="member owl" data-animation="fadeInUp" data-delay="<?php echo esc_attr($block_id * 200); ?>">
				<?php if ($photo_url): ?>
				<img class="member__photo" src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($name); ?>"
					loading="lazy">
				<?php endif; ?>
				<div class="member__info">
					<?php if ($name): ?>
					<h4 class="member__name"><?php echo esc_html($name); ?></h4>
					<?php endif; ?>
					<?php if ($position): ?>
					<span class="member__position"><?php echo esc_html($position); ?></span>
					<?php endif; ?>
					<?php if ($email): ?>
					<a class="member__email" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
	</div>
</section>