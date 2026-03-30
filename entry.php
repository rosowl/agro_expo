<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (is_singular()) {
		echo '<div class="container">';
	} ?>

	<header>
		<?php if (is_singular()) {
			echo '<h1 class="title" itemprop="headline">';
		} else {
			echo '<h3 class="title">';
		} ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
		<?php if (is_singular()) {
			echo '</h1>';
		} else {
			echo '</h3>';
		} ?>
		<?php //edit_post_link();
		?>
		<?php if (!is_search()) {
			get_template_part('entry', 'meta');
		} ?>
	</header>
	<?php get_template_part('entry', (is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content'));		?>

	<?php if (is_singular()) {
		get_template_part('entry-footer');
	} ?>

	<?php if (is_singular()) {
		echo '</div>';
	} ?>
</article>