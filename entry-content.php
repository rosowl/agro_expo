<div class="entry-content" itemprop="mainEntityOfPage">
	<?php if (has_post_thumbnail()) : ?>
		<?php the_post_thumbnail('2k', array('itemprop' => 'image')); ?>
	<?php endif; ?>
	<meta itemprop="description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
	<?php the_content(); ?>
	<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>