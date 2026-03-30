<?php
$section_id    = get_query_var('section_id');
$program_title = get_sub_field('program_title') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="section section--program">
	<div class="container">
		<?php if ($program_title): ?>
			<h3 class="title"><?php echo esc_html($program_title); ?></h3>
		<?php endif; ?>
		<?php if (have_rows('event')): ?>
			<div class="program-events">
				<?php while (have_rows('event')): the_row(); ?>
					<?php
					$block_index = get_row_index();
					$title      = get_sub_field('title') ?: '';
					$date_1     = get_sub_field('date_1') ?: '';
					$time_1     = get_sub_field('time_1') ?: '';
					$date_2     = get_sub_field('date_2') ?: '';
					$time_2     = get_sub_field('time_2') ?: '';
					?>
					<div class="event owl" data-animation="fadeInLeft" data-delay="<?php echo esc_attr($block_index * 100); ?>">
						<?php if ($title): ?>
							<div class="event-title"><?php echo wp_kses_post($title); ?></div>
						<?php endif; ?>
						<div>
							<?php if ($date_1): ?>
								<div class="event-date"><?php echo esc_html($date_1); ?></div>
							<?php endif; ?>
							<?php if ($date_2): ?>
								<div class="event-date"><?php echo esc_html($date_2); ?></div>
							<?php endif; ?>

						</div>
						<div>
							<?php if ($time_1): ?>
								<div class="event-time"><?php echo esc_html($time_1); ?></div>
							<?php endif; ?>
							<?php if ($time_2): ?>
								<div class="event-time"><?php echo esc_html($time_2); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>