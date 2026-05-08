<?php
// Подключение вспомогательных функций для ACF
require_once get_template_directory() . '/inc/acf-helpers.php';

add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    // Removed custom logo support to avoid Customizer logo upload crash.
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets']);
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');
    add_theme_support('appearance-tools');
    add_theme_support('woocommerce');
    global $content_width;
    if (! isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus([
        'main-menu'     => esc_html__('Main Menu', 'blankslate'),
        'footer-menu-1' => esc_html__('Footer Menu 1', 'blankslate'),
        'footer-menu-2' => esc_html__('Footer Menu 2', 'blankslate'),
    ]);
}
add_action('admin_notices', 'blankslate_notice');
function blankslate_notice()
{
    $user_id = get_current_user_id();
    if (! $user_id || ! current_user_can('manage_options') || get_user_meta($user_id, 'blankslate_notice_dismissed_2026', true)) {
        return;
    }
    $dismiss_url = add_query_arg(['blankslate_dismiss' => '1', 'blankslate_nonce' => wp_create_nonce('blankslate_dismiss_notice')], admin_url());
    echo '<div class="notice notice-info"><p><a href="' . esc_url($dismiss_url) . '" class="alignright" style="text-decoration:none"><big>' . esc_html__('×', 'blankslate') . '</big></a><big><strong>' . esc_html__('📝 Thank you for using BlankSlate!', 'blankslate') . '</strong></big><p>' . esc_html__('Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate') . '</p><a href="https://github.com/webguyio/blankslate/issues/57" class="button-primary" target="_blank" rel="noopener noreferrer"><strong>' . esc_html__('How do you use BlankSlate?', 'blankslate') . '</strong></a> <a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank" rel="noopener noreferrer"><strong>' . esc_html__('Donate', 'blankslate') . '</strong></a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank" rel="noopener noreferrer"><strong>' . esc_html__('Review', 'blankslate') . '</strong></a> <a href="https://github.com/webguyio/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank" rel="noopener noreferrer"><strong>' . esc_html__('Support', 'blankslate') . '</strong></a></p></div>';
}
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['blankslate_dismiss'], $_GET['blankslate_nonce']) && wp_verify_nonce($_GET['blankslate_nonce'], 'blankslate_dismiss_notice') && current_user_can('manage_options')) {
        add_user_meta($user_id, 'blankslate_notice_dismissed_2026', 'true', true);
    }
}
add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue()
{
    // ============ КРИТИЧЕСКИЕ СТИЛИ (INLINE) ============
    // Добавляем critical CSS inline в head для LCP
    add_action('wp_head', function () {
        echo '<style>



        </style>';
    }, 5);

    // ============ СТИЛИ ============
    wp_enqueue_style('agro-modal-style', get_template_directory_uri() . '/assets/css/modal.css', [], '1.0');
    wp_enqueue_style('blankslate-style', get_stylesheet_uri(), [], '1.0');

    // ============ СКРИПТЫ ============
    // FSLightbox - отложенная загрузка (не критичен для LCP)
    wp_enqueue_script('fslightbox-script', get_template_directory_uri() . '/assets/js/fslightbox.js', [], '3.7.5', true);

    // Splide - КРИТИЧЕН!
    wp_enqueue_script('splide-script', get_template_directory_uri() . '/assets/slider/splide.min.js', [], '4.1.2', true);
    wp_enqueue_script('splide-scroll-script', get_template_directory_uri() . '/assets/slider/splide-extension-auto-scroll.min.js', ['splide-script'], '4.1.2', true);

    // Основные скрипты - КРИТИЧНЫ!
    wp_enqueue_script('agro-theme-scripts', get_template_directory_uri() . '/assets/js/theme-scripts.js', ['splide-script', 'splide-scroll-script'], '1.0', true);
    wp_enqueue_script('agro-modal', get_template_directory_uri() . '/assets/js/modal.js', ['agro-theme-scripts'], '1.0', true);

    // Локализация для таймера
    wp_localize_script('agro-theme-scripts', 'agro_theme_data', [
        'countdown_date' => get_theme_mod('agro_countdown_date', 'September 16 2026 10:00:00 GMT+0300'),
    ]);
}

// ============ ОТКЛЮЧАЕМ JQUERY ГЛОБАЛЬНО ============
add_action('wp_enqueue_scripts', 'blankslate_dequeue_jquery', 100);
function blankslate_dequeue_jquery()
{
    wp_dequeue_script('jquery');
    wp_dequeue_script('jquery-migrate');
}

// ============ ОПТИМИЗАЦИИ ДЛЯ ПРОИЗВОДИТЕЛЬНОСТИ ============
add_action('wp_head', function () {
    // 1. Prefetch DNS для внешних ресурсов
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//cdn.jsdelivr.net">' . "\n";

    // 2. Preconnect для критичных ресурсов
    echo '<link rel="preconnect" href="//fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="//fonts.gstatic.com" crossorigin>' . "\n";
}, 1);

// ============ АСИНХРОННАЯ ЗАГРУЗКА НЕКРИТИЧНЫХ СКРИПТОВ ============
add_filter('script_loader_tag', function ($tag, $handle) {
    if (in_array($handle, ['fslightbox-script'])) {
        return str_replace('src=', 'async src=', $tag);
    }
    return $tag;
}, 10, 2);

// ============ ОПТИМИЗАЦИЯ ИЗОБРАЖЕНИЙ ============
// Добавляем атрибут fetchpriority для LCP изображений
add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
    // Для первого изображения (LCP) - high priority
    static $image_count = 0;
    $image_count++;

    if ($image_count <= 1) {
        $attr['fetchpriority'] = 'high';
        $attr['loading'] = 'eager';  // Отменяем lazy loading для LCP
    } else {
        $attr['loading'] = 'lazy';
    }

    return $attr;
}, 10, 3);

// ============ MOBILE OPTIMIZATION - ОТЛОЖЕННАЯ ЗАГРУЗКА CSS ============
add_action('wp_footer', function () {
    echo '<script>';
    echo 'if(navigator.connection&&navigator.connection.effectiveType==="4g"){document.documentElement.style.setProperty("--mobile-optimized","1");}';
    echo 'function loadDeferredCSS(){var links=document.querySelectorAll("link[data-defer]");links.forEach(l=>l.removeAttribute("data-defer"));}';
    echo 'if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",loadDeferredCSS);}else{loadDeferredCSS();}';
    echo '</script>' . "\n";
}, 5);

add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
?>
    <script>
        (function() {
            const ua = navigator.userAgent.toLowerCase();
            const html = document.documentElement;
            if (/(iphone|ipod|ipad)/.test(ua)) {
                html.classList.add('ios', 'mobile');
            } else if (/android/.test(ua)) {
                html.classList.add('android', 'mobile');
            } else {
                html.classList.add('desktop');
            }
            if (/chrome/.test(ua) && !/edg|brave/.test(ua)) {
                html.classList.add('chrome');
            } else if (/safari/.test(ua) && !/chrome/.test(ua)) {
                html.classList.add('safari');
            } else if (/edg/.test(ua)) {
                html.classList.add('edge');
            } else if (/firefox/.test(ua)) {
                html.classList.add('firefox');
            } else if (/brave/.test(ua)) {
                html.classList.add('brave');
            } else if (/opr|opera/.test(ua)) {
                html.classList.add('opera');
            }
        })();
    </script>
<?php
}
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}
function blankslate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (! function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (! is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (! is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
function disable_default_image_sizes()
{
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');
}
add_action('init', 'disable_default_image_sizes');

add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar([
        'name'          => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id'            => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

// ===== CUSTOMIZER: Social Media Links & Timer =====
add_action('customize_register', 'agro_customize_register');
function agro_customize_register($wp_customize)
{
    // ===== FOOTER CUSTOMIZER =====
    $wp_customize->add_section('agro_footer', [
        'title'       => esc_html__('Футер: настройки', 'blankslate'),
        'description' => esc_html__('Заголовки меню, подписки и логотип для футера', 'blankslate'),
        'priority'    => 130,
    ]);

    // Заголовок меню 1
    $wp_customize->add_setting('agro_footer_menu1_title', [
        'default'           => 'О выставке',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_footer_menu1_title', [
        'label'   => esc_html__('Заголовок меню 1', 'blankslate'),
        'section' => 'agro_footer',
        'type'    => 'text',
    ]);

    // Заголовок меню 2
    $wp_customize->add_setting('agro_footer_menu2_title', [
        'default'           => 'Участникам',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_footer_menu2_title', [
        'label'   => esc_html__('Заголовок меню 2', 'blankslate'),
        'section' => 'agro_footer',
        'type'    => 'text',
    ]);

    // Заголовок подписки
    $wp_customize->add_setting('agro_footer_subscribe_title', [
        'default'           => 'Подписка на новости',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_footer_subscribe_title', [
        'label'   => esc_html__('Заголовок блока подписки', 'blankslate'),
        'section' => 'agro_footer',
        'type'    => 'text',
    ]);

    // SVG-код логотипа
    $wp_customize->add_setting('agro_footer_logo_svg', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('agro_footer_logo_svg', [
        'label'       => esc_html__('SVG-код логотипа (приоритетнее)', 'blankslate'),
        'section'     => 'agro_footer',
        'type'        => 'textarea',
        'description' => esc_html__('Вставьте SVG-код логотипа. Если не заполнено — будет использоваться изображение ниже.', 'blankslate'),
    ]);

    // Картинка логотипа (альтернатива SVG)
    $wp_customize->add_setting('agro_footer_logo_img', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'agro_footer_logo_img', [
        'label'       => esc_html__('Изображение логотипа (PNG/JPG)', 'blankslate'),
        'section'     => 'agro_footer',
        'settings'    => 'agro_footer_logo_img',
        'description' => esc_html__('Если SVG не задан, будет использоваться это изображение.', 'blankslate'),
    ]));

    // Шорткод формы подписки
    $wp_customize->add_setting('agro_footer_subscribe_shortcode', [
        'default'           => '[contact-form-7 id="123" title="Подписка на новости"]',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_footer_subscribe_shortcode', [
        'label'   => esc_html__('Шорткод формы подписки', 'blankslate'),
        'section' => 'agro_footer',
        'type'    => 'text',
    ]);

    // Секция для таймера
    $wp_customize->add_section('agro_countdown', [
        'title'       => esc_html__('Таймер обратного отсчета', 'blankslate'),
        'description' => esc_html__('Настройки для таймера обратного отсчета', 'blankslate'),
        'priority'    => 121,
    ]);

    // Дата таймера
    $wp_customize->add_setting('agro_countdown_date', [
        'default'           => 'September 16 2026 10:00:00 GMT+0300',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_countdown_date', [
        'label'       => esc_html__('Дата и время таймера', 'blankslate'),
        'description' => esc_html__('Пример: September 16 2026 10:00:00 GMT+0300', 'blankslate'),
        'section'     => 'agro_countdown',
        'type'        => 'text',
    ]);

    // ===== STYLES SECTION =====
    $wp_customize->add_section('agro_styles', [
        'title'       => esc_html__('Стили', 'blankslate'),
        'description' => esc_html__('Основные цвета и параметры оформления', 'blankslate'),
        'priority'    => 121,
    ]);

    // Brand Color
    $wp_customize->add_setting('agro_brand_color', [
        'default'           => '#73cae5',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'agro_brand_color', [
        'label'    => esc_html__('Брендовый цвет', 'blankslate'),
        'section'  => 'agro_styles',
        'settings' => 'agro_brand_color',
    ]));

    // Accent Color
    $wp_customize->add_setting('agro_accent_color', [
        'default'           => '#87c74d',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'agro_accent_color', [
        'label'    => esc_html__('Акцентовый цвет', 'blankslate'),
        'section'  => 'agro_styles',
        'settings' => 'agro_accent_color',
    ]));

    // Dark background color
    $wp_customize->add_setting('agro_dark_background_color', [
        'default'           => '#0D0D0D',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'agro_dark_background_color', [
        'label'    => esc_html__('Тёмный фон', 'blankslate'),
        'section'  => 'agro_styles',
        'settings' => 'agro_dark_background_color',
    ]));

    // Primary text color
    $wp_customize->add_setting('agro_primary_color', [
        'default'           => '#424242',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'agro_primary_color', [
        'label'    => esc_html__('Базовый текст', 'blankslate'),
        'section'  => 'agro_styles',
        'settings' => 'agro_primary_color',
    ]));

    // Secondary text color
    $wp_customize->add_setting('agro_secondary_color', [
        'default'           => '#b7b7b7',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'agro_secondary_color', [
        'label'    => esc_html__('Вторичный текст', 'blankslate'),
        'section'  => 'agro_styles',
        'settings' => 'agro_secondary_color',
    ]));

    // Container Width
    $wp_customize->add_setting('agro_container_width', [
        'default'           => '1280px',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_container_width', [
        'label'       => esc_html__('Ширина контейнера', 'blankslate'),
        'section'     => 'agro_styles',
        'type'        => 'text',
        'description' => esc_html__('Например: 1280px, 1200px, 100%', 'blankslate'),
    ]);

    // Border Radius
    $wp_customize->add_setting('agro_border_radius', [
        'default'           => '3px',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_border_radius', [
        'label'       => esc_html__('Закругления элементов', 'blankslate'),
        'section'     => 'agro_styles',
        'type'        => 'text',
        'description' => esc_html__('Например: 3px, 5px, 8px', 'blankslate'),
    ]);

    // Секция для соцсетей
    $wp_customize->add_section('agro_social_links', [
        'title'       => esc_html__('Социальные сети', 'blankslate'),
        'description' => esc_html__('Ссылки на профили в социальных сетях', 'blankslate'),
        'priority'    => 120,
    ]);

    // Facebook
    $wp_customize->add_setting('agro_facebook_url', [
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agro_facebook_url', [
        'label'   => esc_html__('Facebook URL', 'blankslate'),
        'section' => 'agro_social_links',
        'type'    => 'url',
    ]);

    // Instagram
    $wp_customize->add_setting('agro_instagram_url', [
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agro_instagram_url', [
        'label'   => esc_html__('Instagram URL', 'blankslate'),
        'section' => 'agro_social_links',
        'type'    => 'url',
    ]);

    // TikTok
    $wp_customize->add_setting('agro_tiktok_url', [
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agro_tiktok_url', [
        'label'   => esc_html__('TikTok URL', 'blankslate'),
        'section' => 'agro_social_links',
        'type'    => 'url',
    ]);

    // YouTube
    $wp_customize->add_setting('agro_youtube_url', [
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('agro_youtube_url', [
        'label'   => esc_html__('YouTube URL', 'blankslate'),
        'section' => 'agro_social_links',
        'type'    => 'url',
    ]);

    // Phone
    $wp_customize->add_setting('agro_phone_url', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('agro_phone_url', [
        'label'   => esc_html__('Phone Link (tel: or http:)', 'blankslate'),
        'section' => 'agro_social_links',
        'type'    => 'text',
    ]);
}

// Функция для вывода соцсетей в шаблонах
function agro_get_social_links()
{
    $socials = [
        'facebook'  => [
            'url'   => get_theme_mod('agro_facebook_url'),
            'icon'  => 'logo-facebook.svg',
            'label' => 'Facebook',
        ],
        'instagram' => [
            'url'   => get_theme_mod('agro_instagram_url'),
            'icon'  => 'logo-instagram.svg',
            'label' => 'Instagram',
        ],
        'tiktok'    => [
            'url'   => get_theme_mod('agro_tiktok_url'),
            'icon'  => 'logo-tiktok.svg',
            'label' => 'TikTok',
        ],
        'youtube'   => [
            'url'   => get_theme_mod('agro_youtube_url'),
            'icon'  => 'logo-youtube.svg',
            'label' => 'YouTube',
        ],
    ];
    return $socials;
}

function agro_get_phone_link()
{
    $socials = [
        'phone' => [
            'url'   => get_theme_mod('agro_phone_url'),
            'icon'  => 'logo-phone.svg',
            'label' => 'Phone',
        ],
    ];
    return $socials;
}

// Добавляем свои размеры
add_action('after_setup_theme', 'my_theme_image_sizes');

function my_theme_image_sizes()
{
    // Для карточек записей в блоге
    add_image_size('2k', 2560, 1440, false);

    // Для главного слайдера
    add_image_size('4k', 3840, 2160, false);
}

// Добавляем в выпадающий список админки
add_filter('image_size_names_choose', 'my_theme_image_size_choices');

function my_theme_image_size_choices($sizes)
{
    return array_merge($sizes, array(
        '2k' => __('2k'),
        '4k' => __('4k'),
    ));
}



// В functions.php
function custom_excerpt_archive_length($excerpt)
{
    // Проверяем, что мы на странице архива/поиска/главной
    if (is_archive() || is_search() || is_home() || is_front_page()) {
        $max_length = 120; // установите нужную длину

        // Получаем "чистый" текст без HTML
        $plain_excerpt = wp_strip_all_tags($excerpt, true);

        if (mb_strlen($plain_excerpt) > $max_length) {
            // Обрезаем до последнего слова
            $trimmed = mb_substr($plain_excerpt, 0, $max_length);
            $last_space = mb_strrpos($trimmed, ' ');

            if ($last_space !== false) {
                $trimmed = mb_substr($trimmed, 0, $last_space);
            }

            $excerpt = $trimmed . '...';
        }
    }

    return $excerpt;
}
add_filter('get_the_excerpt', 'custom_excerpt_archive_length', 999, 1);

// Также изменяем длину автоматического excerpt (количество слов)
function custom_excerpt_word_length($length)
{
    if (is_archive() || is_search() || is_home() || is_front_page()) {
        return 30; // количество слов (примерно 150-200 символов)
    }
    return $length;
}
add_filter('excerpt_length', 'custom_excerpt_word_length', 999);
