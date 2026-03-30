# Архитектура шаблонов и компонентов

## Структура папок

```
template-parts/
├── components/          # Переиспользуемые компоненты
│   ├── slider.php      # Splide slider
│   ├── countdown.php   # Обратный отсчет
│   └── parallax.php    # Параллакс блок
└── acf/                # ACF специфичные шаблоны
    └── section.php     # Генерическая секция для ACF
```

## Использование компонентов

### 1. Slider (Splide)

```php
<?php get_template_part('template-parts/components/slider'); ?>
```

**Особенности:**
- Автоматически генерирует уникальные id для каждого экземпляра
- Проверяет наличие Splide перед инициализацией
- Можно использовать несколько на одной странице

### 2. Countdown (Обратный отсчет)

```php
<?php get_template_part('template-parts/components/countdown'); ?>
```

**Особенности:**
- Использует встроенный обработчик из `theme-scripts.js`
- ID: `countdown` (используется `theme-scripts.js` автоматически)
- Дата берется из настроек темы: `agro_theme_data.countdown_date`

### 3. Parallax

```php
<?php get_template_part('template-parts/components/parallax'); ?>
```

**Особенности:**
- Использует встроенный обработчик parallax эффектов
- Может принимать аргументы с изображением

### 4. ACF Section (Генерическая секция)

Используется при создании Flexible Content или Repeater полей в ACF:

```php
// В page.php или index.php:
<?php agro_render_sections(); ?>
```

**Ожидаемая структура данных ACF:**
```php
$sections = [
    [
        'type' => 'default',
        'title' => 'Заголовок секции',
        'description' => 'Описание',
        'background' => 'url-изображения'
    ]
];
```

## Вспомогательные функции (inc/acf-helpers.php)

## Owl animation library

Библиотека лёгких CSS-анимаций при прокрутке. Работает по аналогии с WOW.js,
но написана специально для проекта, чтобы не тащить сторонние зависимости.

### Как применять

1. Добавьте класс `owl` к любому блоку, который должен анимироваться при
   появлении в области видимости.
2. Укажите анимацию через `data-animation` — это строка, совпадающая с
   именами ключевых кадров в `style.css` (`fadeInUp`, `slideInLeft` и т.д.).
3. При необходимости можно задать `data-delay` в миллисекундах; если атрибут
   отсутствует, применяется глобальная задержка 400 ms (настраивается).

```html
<!-- простой пример -->
<div class="owl" data-animation="fadeInUp">
    <p>Контент, который появится при прокрутке</p>
</div>

<!-- с индивидуальной задержкой 0.8 секунды -->
<div class="owl" data-animation="slideInRight" data-delay="800">
    <img src="..." alt="">
</div>
```

### Конфигурация

При инициализации скрипта (в `theme-scripts.js`) можно передать объект
с настройками:

```js
new AnimaOwl({
  boxClass: 'owl',        // класс для поиска элементов
  animateClass: 'animated', // класс, добавляемый при срабатывании
  offset: 50,            // расстояние до нижнего края окна
  delay: 400             // глобальная задержка (ms)
});
```

Скрипт автоматически находит элементы с указанным классом и следит за
прокруткой/изменением размеров окна. Когда элемент попадает в зону
`window.innerHeight - offset` — ему добавляются классы `animated` и
`<имя-анимации>`.

> **Примечание:** в CSS-переменные и сами ключевые кадры анимаций находятся
> в секции `@layer utilities` файла `style.css`.

---


### agro_get_field($field_name, $post_id = false)
Безопасное получение значения ACF поля

```php
$title = agro_get_field('page_title');
```

### agro_get_image($field, $post_id = false, $size = 'large')
Безопасное получение URL изображения из ACF

```php
$image = agro_get_image('hero_image');
```

### agro_render_sections($post_id = false)
Рендер всех секций из повторителя

```php
agro_render_sections();
```

## Пример использования в page.php

```php
<?php get_header(); ?>

<!-- Компоненты -->
<?php get_template_part('template-parts/components/slider'); ?>
<?php get_template_part('template-parts/components/countdown'); ?>

<!-- ACF секции (Flexible Content) -->
<?php agro_render_sections(); ?>

<!-- Обычной контент странички -->
<main>
    <?php the_content(); ?>
</main>

<?php get_footer(); ?>
```

## Важные моменты

1. **Countdown ID**: Элемент всегда имеет ID `countdown` для совместимости с `theme-scripts.js`
2. **Slider**: Каждый слайдер получает уникальный ID для избежания конфликтов
3. **ACF**: Функции проверяют наличие ACF перед использованием
4. **Ошибки**: Все компоненты имеют fallback для безопасности

## Настройка темы для countdown

В `functions.php` можно передать дату обратного отсчета:

```php
wp_localize_script('theme-scripts', 'agro_theme_data', [
    'countdown_date' => 'February 10 2026 18:00:00 GMT+0200'
]);
```
