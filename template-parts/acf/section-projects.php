<?php
$section_id     = get_query_var('section_id');
$projects_title = get_sub_field('projects_title') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="section section--projects">
	<div class="container container--wide no-padding">
		<?php if ($projects_title): ?>
			<h2 class="title"><?php echo esc_html($projects_title); ?></h2>
		<?php endif; ?>
		<?php if (have_rows('project')): ?>
			<div class="projects-grid">
				<?php while (have_rows('project')): the_row(); ?>
					<?php
					$block_index          = get_row_index();
					$project_image_id     = get_sub_field('project_image');
					$project_image_url   = $project_image_id ? wp_get_attachment_image_url($project_image_id, 'medium_large') : '';
					$project_image_alt   = $project_image_id ? get_post_meta($project_image_id, '_wp_attachment_image_alt', true) : '';
					$project_description = get_sub_field('project_description') ?: '';
					$project_link        = get_sub_field('project_link') ?: '';
					$project_button      = get_sub_field('project_button') ?: '';
					?>
					<div class="project-item owl" data-delay="<?php echo esc_attr($block_index * 100); ?>">
						<?php if ($project_image_url): ?>
							<picture class="project-item__image">
								<img src="<?php echo esc_url($project_image_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
							</picture>
						<?php endif; ?>
						<div class="project-item__description">
							<?php if ($project_description): ?>
								<?php echo wp_kses_post($project_description); ?>
							<?php endif; ?>
							<?php if ($project_link && $project_button): ?>
								<a class="project-item__button btn btn--outlined"
									href="<?php echo esc_url($project_link); ?>" target="_blank"><?php echo esc_html($project_button); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>