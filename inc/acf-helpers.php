<?php
// Вспомогательные функции для безопасной работы с ACF

if (! function_exists('agro_get_field')) {
    function agro_get_field($field_name, $post_id = false)
    {
        if (! function_exists('get_field')) {
            return null;
        }
        return get_field($field_name, $post_id);
    }
}

if (! function_exists('agro_get_image')) {
    function agro_get_image($field, $post_id = false, $size = 'large')
    {
        $image = agro_get_field($field, $post_id);
        if (! $image) {
            return '';
        }
        if (is_array($image) && isset($image['ID'])) {
            return wp_get_attachment_image_url($image['ID'], $size);
        }
        return wp_get_attachment_image_url($image, $size);
    }
}

// Return a sub-field value but unwrap cloned select fields that return
// arrays. ACF's clone field sometimes spits out an array with a "value"
// key instead of the raw string, causing `echo` to print "Array". Use
// this helper whenever you read a select/clone underneath a flexible
// content layout.
if (! function_exists('agro_get_sub_field')) {
    function agro_get_sub_field($field_name)
    {
        if (! function_exists('get_sub_field')) {
            return null;
        }
        $value = get_sub_field($field_name);
        if (is_array($value)) {
            // a cloned select sometimes comes back as [ 'value' => 'foo' ]
            if (isset($value['value'])) {
                return $value['value'];
            }
            // other times it might be [ 'field_…' => 'foo' ] or similar;
            // take the first string element we can find.
            foreach ($value as $v) {
                if (is_string($v)) {
                    return $v;
                }
            }
            // fallback to empty string – nothing useful here.
            return '';
        }
        return $value;
    }
}

if (! function_exists('agro_render_sections')) {
    // Ожидается, что поле 'makets' содержит flexible content
    function agro_render_sections($post_id = false)
    {
        if (have_rows('makets', $post_id)) {
            while (have_rows('makets', $post_id)) {
                the_row();
                $section_index++;
                $layout = get_row_layout();

                // Создаём ID на основе названия макета и индекса
                $section_id = $layout . '-' . $section_index;

                // Передаём ID в template part через массив аргументов
                set_query_var('section_id', $section_id);
                set_query_var('section_layout', $layout);
                set_query_var('section_index', $section_index);
                // Передаём данные секции как аргумент в template part
                // WP будет пытаться загрузить template-parts/acf/section-{name}.php
                get_template_part('template-parts/acf/section', $layout);
            }
        }
    }
}