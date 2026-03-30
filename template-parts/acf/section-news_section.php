<?php
$section_id  = get_query_var('section_id');
$title       = get_sub_field('title') ?: '';
$button_text = get_sub_field('more_button') ?: '';
?>
<section id="<?php echo esc_attr($section_id); ?>" class="section section--news_section">
	<div class="container">
		<?php if ($title): ?>
		<h2 class="title"><?php echo esc_html($title); ?></h2>
		<?php endif; ?>
		<?php if (have_rows('select_news')): ?>
		<div class="news-list">
			<?php while (have_rows('select_news')): the_row(); ?>
			<?php
					$news = get_sub_field('news');
					if ($news):
						$block_id = get_row_index();
						$news_id        = $news;
						$featured_image = get_the_post_thumbnail_url($news_id, 'medium_large');
						$post_date      = get_the_date('j F Y', $news_id);
						$post_title     = get_the_title($news_id);
						$post_url       = get_permalink($news_id);
					?>
			<article class="news-item owl" data-animation="fadeIn" data-delay="<?php echo esc_attr($block_id * 200); ?>">
				<a href="<?php echo esc_url($post_url); ?>" class="news-item__link">
					<?php if ($featured_image): ?>
					<div class="news-item__image">
						<img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($post_title); ?>"
							loading="lazy">
					</div>
					<?php endif; ?>
					<div class="news-item__date"><?php echo esc_html($post_date); ?></div>
					<h3 class="news-item__title"><?php echo esc_html($post_title); ?></h3>
				</a>
			</article>
			<?php endif; ?>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>

		<?php if ($button_text): ?>
		<div class="news-section__button-wrapper">
			<a href="<?php echo esc_url(home_url('/news/')); ?>"
				class="btn btn--secondary"><?php echo esc_html($button_text); ?></a>
		</div>
		<?php endif; ?>
	</div>
</section>