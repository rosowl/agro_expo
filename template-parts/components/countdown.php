<?php
// Countdown component: expects a `data-target` string that Date.parse can
// understand. If the caller provides an explicit target via $args['target'],
// that value is used. Otherwise we fall back to the global date set in the
// customizer (`agro_countdown_date`).
$target = '';
if (isset($args) && is_array($args) && ! empty($args['target'])) {
	$target = $args['target'];
} else {
	$target = get_theme_mod('agro_countdown_date', '2026-09-16T10:00:00+00:00');
}
?>
<div id="countdown" class="countdown" role="timer" aria-live="polite" data-target="<?php echo esc_attr($target); ?>">
	<div class="countdown-number">
		<span class="days countdown-time" aria-label="дни">--</span>
		<span class="countdown-text">днів</span>
	</div>
	<div class="countdown-number">
		<span class="hours countdown-time" aria-label="години">--</span>
		<span class="countdown-text">годин</span>
	</div>
	<div class="countdown-number">
		<span class="minutes countdown-time" aria-label="хвилини">--</span>
		<span class="countdown-text">хвилин</span>
	</div>
	<div class="countdown-number">
		<span class="seconds countdown-time" aria-label="секунди">--</span>
		<span class="countdown-text">секунд</span>
	</div>
</div>