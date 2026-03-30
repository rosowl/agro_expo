<?php
$section_id    = get_query_var('section_id');
$section_slope = agro_get_sub_field('section_slope') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--exhibition_figures <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>">
	<div class="container">
		<?php if (have_rows('figure')): ?>
			<div class="figures-grid owl" data-animation="slideInLeft">
				<?php while (have_rows('figure')): the_row(); ?>
					<?php
					$num  = get_sub_field('figure_number') ?: '';
					$txt = get_sub_field('figure_text') ?: '';
					?>
					<div class="figure-item">
						<?php if ($num): ?><div class="figure-number"><?php echo esc_html($num); ?></div><?php endif; ?>
						<hr class="figure-separator">
						<?php if ($txt): ?><div class="figure-text"><?php echo esc_html($txt); ?></div><?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>