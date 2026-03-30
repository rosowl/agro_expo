<?php
$section_id = get_query_var('section_id');
$seo_text   = get_sub_field('seo_text') ?: '';
?>
<?php if ($seo_text): ?>
    <section id="<?php echo esc_attr($section_id); ?>" class="section section--seo">
        <div class="container">
            <div class="seo-text"><?php echo wp_kses_post($seo_text); ?></div>
        </div>
    </section>
<?php endif; ?>