<?php
$video_link    = get_sub_field('video_url') ?: '';
$video_title   = get_sub_field('video_title') ?: '';
$bg_color 		 = get_sub_field('background_color') ?: 'hsl(from var(--dark-background-color) h s l / 0.3)';
$section_id    = get_query_var('section_id');
$section_slope = agro_get_sub_field('section_slope') ?: '';

// Convert YouTube URL to embed format
$embed_url = '';
if ($video_link) {
	// Handles: https://youtu.be/VIDEO_ID, https://www.youtube.com/watch?v=VIDEO_ID
	if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_link, $matches)) {
		$video_id       = $matches[1];
		$embed_url      = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=1&mute=1&loop=1&controls=0&playlist=' . $video_id;
		$embed_url_full = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=0&mute=0&loop=0&controls=1&modestbranding=1&rel=0';
	}
}

?>
<?php
$lightbox_id = 'video-' . $section_id;
?>
<section id="<?php echo esc_attr($section_id); ?>"
	class="section section--video <?php echo $section_slope ? esc_attr($section_slope) : ''; ?>">
	<!-- Background video -->
	<?php if ($embed_url): ?>
		<div class="video-background">
			<iframe title="<?php echo esc_attr($video_title ?: 'Video'); ?>	" class="video-background__iframe" src="<?php echo esc_url($embed_url); ?>" frameborder="0"
				allow="autoplay; encrypted-media; mute" allowfullscreen loading="lazy"></iframe>
		</div>

		<!-- Lightbox trigger overlay -->
		<a href="<?php echo esc_url($video_link); ?>" class="video-overlay" style="background-color: <?php echo $bg_color; ?>"
			data-fslightbox="<?php echo esc_attr($lightbox_id); ?>"
			aria-label="<?php echo esc_attr($video_title ?: 'Открыть видео'); ?>">
			<span class="video-overlay__play"></span>
		</a>
	<?php endif; ?>
</section>