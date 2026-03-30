<?php
$section_id    = get_query_var('section_id');
$section_title = get_sub_field('section_participants_title') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="section section--participants">
	<div class="container">
		<?php if ($section_title): ?>
			<h2 class="title"><?php echo esc_html($section_title); ?></h2>
		<?php endif; ?>
		<?php if (have_rows('participants_block')): ?>
			<?php $block_index = 0;
			while (have_rows('participants_block')): the_row(); ?>
				<?php
				$block_title    = get_sub_field('participants_title') ?: '';
				$logos_in_row  = (int) get_sub_field('logos_in_row') ?: 7;
				$rows_in_slide = (int) get_sub_field('rows_in_slide') ?: 3;
				$interval = (int) get_sub_field('slider_speed') ?: 3;
				$ticker = (bool) get_sub_field('ticker');
				$slider_class  = 'participants-slider-' . $block_index;
				?>
				<div class="participants owl" data-animation="<?php if ($block_index % 2 === 1):
																												echo 'slideInLeft';
																											else:
																												echo 'slideInRight';
																											endif; ?>" data-delay="<?php echo $block_index * 100; ?>">
					<?php if ($block_title): ?>
						<h3 class="participants__title"><?php echo esc_html($block_title); ?></h3>
					<?php endif; ?>
					<?php if (have_rows('participant')): ?>
						<div class="participants__slider-wrapper">
							<div class="splide <?php echo esc_attr($slider_class); ?>" data-interval="<?php echo $interval; ?>"
								data-ticker="<?php echo esc_attr($ticker ? 'true' : 'false'); ?>"
								data-logos-in-row="<?php echo $logos_in_row; ?>" data-rows-in-slide="<?php echo $rows_in_slide; ?>">
								<!-- <style>
									<?php // echo '.' . $slider_class . '.splide--loop .splide__slide';
									?> {
										max-width: calc(100% / <?php //echo $logos_in_row;
																						?>);
									}
								</style> -->
								<div class="splide__track">
									<ul class="splide__list">
										<?php
										// Собираем все логотипы
										$participants = [];

										while (have_rows('participant')): the_row();
											// Получаем значение visibility, по умолчанию 'visible'
											$visibility = (bool) get_sub_field('visibility');

											// Пропускаем участников с visibility = false
											if (!$visibility) {
												continue;
											}

											$participants[] = [
												'logo_id' 		=> get_sub_field('logo'),
												'name'   	 		=> get_sub_field('name'),
												'link'    		=> get_sub_field('link'),
												'visibility' 	=> get_sub_field('visibility'),
											];
										endwhile;

										$total = count($participants);

										// Кол-во слайдов = кол-во участников разделить на кол-во по вертикали
										$num_columns = ceil($total / $rows_in_slide);

										// Создаём слайды по колонкам
										for ($col = 0; $col < $num_columns; $col++):
											$start = $col * $rows_in_slide;
											$end   = min($start + $rows_in_slide, $total);
										?>
											<li class="splide__slide">
												<div class="participants-grid">
													<?php for ($i = $start; $i < $end; $i++):
														$p        = $participants[$i];
														$logo_url = $p['logo_id'] ? wp_get_attachment_image_url($p['logo_id'], 'medium') : '';
													?>
														<?php if ($logo_url): ?>
															<div class="participant-item">
																<?php if ($p['link']): ?>
																	<a href="<?php echo esc_url($p['link']); ?>" target="_blank" rel="noopener noreferrer">
																		<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($p['name']); ?>"
																			loading="lazy">
																	</a>
																<?php else: ?>
																	<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($p['name']); ?>"
																		loading="lazy">
																<?php endif; ?>
															</div>
														<?php endif; ?>
													<?php endfor; ?>
												</div>
											</li>
										<?php endfor; ?>
									</ul>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php $block_index++;
			endwhile; ?>
		<?php endif; ?>
	</div>
</section>