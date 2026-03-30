<?php
// Простая шаблонная часть для Splide slider (demo)
static $slider_counter = 0;
$slider_counter++;
$slider_id = 'splide-' . $slider_counter;
?>
<section class="splide" id="<?php echo esc_attr($slider_id); ?>" aria-label="Splide Slider">
	<div class="splide__track">
		<ul class="splide__list">
			<li class="splide__slide">Slide 01</li>
			<li class="splide__slide">Slide 02</li>
			<li class="splide__slide">Slide 03</li>
		</ul>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	if (typeof Splide !== 'undefined') {
		var splideElement = document.getElementById('<?php echo esc_js($slider_id); ?>');
		if (splideElement) {
			var splide = new Splide(splideElement);
			splide.mount();
		}
	}
});
</script>