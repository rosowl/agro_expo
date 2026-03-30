<?php get_header(); ?>
<header class="header container">
	<h1 class="title" itemprop="name"><?php single_term_title(); ?></h1>
	<div class="archive-meta" itemprop="description">
		<?php if ('' != get_the_archive_description()) {
			echo wp_kses_post(get_the_archive_description());
		} ?></div>
</header>
<section class="container articles">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part('entry'); ?>
	<?php endwhile;
	endif; ?>
</section>
<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>