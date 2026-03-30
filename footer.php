</main>
<?php get_sidebar(); ?>
<footer id="footer" role="contentinfo" class="section--slope-top-right">
	<div class="container">
		<div class="footer-main">
			<!-- Логотип -->
			<div class="footer-logo owl" data-animation="fadeInLeft" data-delay="100">
				<a href=" /" aria-label="AgroExpo Home" style="display: inline-block;">
					<?php
					$footer_logo_svg = get_theme_mod('agro_footer_logo_svg');
					$footer_logo_img = get_theme_mod('agro_footer_logo_img');
					if ($footer_logo_svg) {
						echo $footer_logo_svg;
					} elseif ($footer_logo_img) {
						echo '<img src="' . esc_url($footer_logo_img) . '" width="100%" height="auto" alt="Logo" loading="lazy">';
					} else {
						// fallback SVG
						echo '<svg width="160" height="48" viewBox="0 0 160 48" fill="none" xmlns="http://www.w3.org/2000/svg"><text x="0" y="36" font-family="Manrope, Arial, sans-serif" font-size="36" fill="white" font-weight="bold">AgroTeam Expo</text></svg>';
					}
					?>
				</a>
			</div>
			<!-- Меню 1 -->
			<div class="footer-menu owl" data-animation="fadeInLeft" data-delay="200">
				<div class="footer-menu-title">
					<?php echo esc_html(get_theme_mod('agro_footer_menu1_title', 'Навігація')); ?>
				</div>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu-1',
					'container'      => false,
					'menu_class'     => 'footer-nav',
					'fallback_cb'    => false,
				]);
				?>
			</div>
			<!-- Меню 2 -->
			<div class="footer-menu owl" data-animation="fadeInLeft" data-delay="300">
				<div class="footer-menu-title">
					<?php echo esc_html(get_theme_mod('agro_footer_menu2_title', 'Допомога')); ?>
				</div>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu-2',
					'container'      => false,
					'menu_class'     => 'footer-nav',
					'fallback_cb'    => false,
				]);
				?>
			</div>
			<!-- Форма подписки -->
			<div class="footer-subscribe owl" data-animation="fadeInLeft" data-delay="400">
				<div class="footer-menu-title">
					<?php echo esc_html(get_theme_mod('agro_footer_subscribe_title', 'Отримувати новини')); ?>
				</div>
				<div class="footer-subscribe-form">
					<?php echo do_shortcode(get_theme_mod('agro_footer_subscribe_shortcode', '[contact-form-7 id="123" title="Подписка на новости"]')); ?>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div>&copy; Сreated by Agro Team Expo <?php echo esc_html(date_i18n(__('Y', 'blankslate'))); ?>.</div>
			<div>All rights Reserved </div>
			<div style="color:#444">| Developed by <a href="https://rosowl.pp.ua" target="_blank" rel="noopener noreferrer" style="color:#444; text-decoration:none;">RosOwl</a></div>
		</div>
	</div>
</footer>

<!-- Universal modal dialog used across site for shortcodes/forms -->
<dialog id="site-modal" class="site-modal">
	<div class="site-modal__wrap">
		<button class="site-modal__close" aria-label="Закрыть">×</button>
		<div id="site-modal-body" class="site-modal__body" role="document"></div>
	</div>
</dialog>

<?php wp_footer(); ?>
</body>

</html>