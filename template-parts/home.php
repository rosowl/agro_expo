<?php
// Общий шаблон для домашней страницы и вывода блоков
?>

<?php if (function_exists('agro_render_sections')): ?>
<?php agro_render_sections(); ?>
<?php endif; ?>


<?php
// Посты/страницы
// if (have_posts()): while (have_posts()): the_post();
//         get_template_part('entry');
//     endwhile;
// endif;

// get_template_part('nav', 'below');
?>