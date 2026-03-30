<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<meta name="google-site-verification" content="k8ZXunXAHubxh6zdfuX0lqNLU1ScQE1l6y-L7LfiLRY" />
	<?php wp_head(); ?>
	<!-- Theme Customizer CSS Variables -->
	<style>
		:root {
			--brand-color: <?php echo esc_attr(get_theme_mod('agro_brand_color', '#73cae5'));
											?>;
			--accent-color: <?php echo esc_attr(get_theme_mod('agro_accent_color', '#87c74d'));
											?>;
			--border-radius: <?php echo esc_attr(get_theme_mod('agro_border_radius', '3px'));
												?>;
			--container-max-width: <?php echo esc_attr(get_theme_mod('agro_container_width', '1280px'));
															?>;
			--dark-background-color: <?php echo esc_attr(get_theme_mod('agro_dark_background_color', '#0D0D0D'));
																?>;
			--primary-color: <?php echo esc_attr(get_theme_mod('agro_primary_color', '#424242'));
												?>;
			--secondary-color: <?php echo esc_attr(get_theme_mod('agro_secondary_color', '#b7b7b7'));
													?>;
		}
	</style>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="wrapper" class="hfeed">
		<header id="header" role="banner">
			<div class="container">
				<div class="header-top slideInDown">
					<!-- Branding: Logo + Title -->

					<?php
					$has_logo  = has_custom_logo();
					$site_name = get_bloginfo('name');

					// Показываем branding только если есть лого или название
					if ($has_logo || ! empty($site_name)) {
						if (is_front_page() || is_home()) {
							echo '<div id="branding"><div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization"><h1>';
						} else {
							echo '<div id="branding"><div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
						}

						echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr($site_name) . '" rel="home" itemprop="url" class="logo-link">';

						if ($has_logo) {
							echo wp_get_custom_logo();
						}

						if (! empty($site_name)) {
							echo '<span itemprop="name" class="site-name">' . esc_html($site_name) . '</span>';
						}

						echo '</a>';

						if (is_front_page() || is_home()) {
							echo '</h1></div></div>';
						} else {
							echo '</div></div>';
						}
					}
					?>
					<nav id="menu" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'blankslate'); ?>"
						itemscope itemtype="https://schema.org/SiteNavigationElement">
						<?php
						wp_nav_menu([
							'theme_location' => 'main-menu',
							'menu_class'     => 'nav-menu',
							'container'      => false,
							'fallback_cb'    => 'wp_page_menu',
							'depth'          => 2,
						]);
						?>

						<!-- Social Links (Header Right) -->
						<div class="header-social">
							<?php
							$socials = agro_get_social_links();
							foreach ($socials as $key => $social) {
								if (! empty($social['url'])) {
									echo '<a href="' . esc_url($social['url']) . '" class="social-link social-' . esc_attr($key) . '" title="' . esc_attr($social['label']) . '" target="_blank" rel="noopener noreferrer">';
									echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/media/' . $social['icon']) . '" alt="' . esc_attr($social['label']) . '" class="social-icon" />';
									echo '</a>';
								}
							}
							?>
						</div>
					</nav>

					<!-- Hamburger Menu Button (Mobile) -->
					<button class="menu-toggle" id="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
						<span></span>
						<span></span>
						<span></span>
					</button>

				</div>
			</div>

			<!-- Mobile Menu Toggle Script -->
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const menuToggle = document.getElementById('mobile-menu-toggle');
					const mobileMenu = document.getElementById('menu');

					if (menuToggle) {
						menuToggle.addEventListener('click', function() {
							menuToggle.classList.toggle('active');
							mobileMenu.classList.toggle('active');
							menuToggle.setAttribute('aria-expanded', menuToggle.getAttribute('aria-expanded') === 'false' ?
								'true' : 'false');
						});

						// Закрыть меню при клике на ссылку
						const menuLinks = mobileMenu.querySelectorAll('a');
						menuLinks.forEach(link => {
							link.addEventListener('click', function() {
								menuToggle.classList.remove('active');
								mobileMenu.classList.remove('active');
								menuToggle.setAttribute('aria-expanded', 'false');
							});
						});
					}
				});
			</script>
		</header>
		<main id="content" role="main">