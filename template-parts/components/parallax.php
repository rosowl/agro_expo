<?php
$image = '';
if (isset($args) && is_array($args) && ! empty($args['image'])) {
	$image = $args['image'];
}
if (! $image) {
	$image = get_template_directory_uri() . '/assets/media/parallax-default.webp';
}
?>

<div class="parallax-container">
	<div class="parallax-bg" data-parallax style="background-image: url('<?php echo esc_url($image); ?>');"></div>
	<h1>This is parallax</h1>
	<div class="mask"></div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const parallaxElements = document.querySelectorAll('[data-parallax]');

		// Коэффициент скорости (чем меньше, тем медленнее движение)
		const speed = 0.2;

		function updateParallax() {
			parallaxElements.forEach(element => {
				const rect = element.parentElement.getBoundingClientRect();
				const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

				if (isVisible) {
					// Смещение = расстояние от верха элемента до верха окна * скорость
					const offset = rect.top * speed;
					// Используем translate3d для плавной анимации
					element.style.transform = `translate3d(0, ${offset}px, 0)`;
				}
			});
		}

		// Вызываем при загрузке и скролле
		updateParallax();
		window.addEventListener('scroll', updateParallax);

		// Оптимизация производительности: используем requestAnimationFrame
		let ticking = false;
		window.addEventListener('scroll', function() {
			if (!ticking) {
				requestAnimationFrame(function() {
					updateParallax();
					ticking = false;
				});
				ticking = true;
			}
		});
	});
</script>