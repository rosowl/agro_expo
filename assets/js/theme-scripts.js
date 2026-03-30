/**
 * Anchor Menu Active State
 * Добавляет класс current-menu-item на якорные ссылки в меню
 */
(function() {
	'use strict';

	function setActiveAnchorMenu() {
		const navLinks = document.querySelectorAll('.nav-menu a, .footer-nav a');
		const currentHash = window.location.hash;
		const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
		const currentUrl = window.location.origin + window.location.pathname + window.location.search + window.location.hash;

		// Сбросим у всех элементов
		navLinks.forEach(link => {
			const parentLi = link.closest('li');
			if (parentLi) parentLi.classList.remove('current-menu-item');
		});

		function setMenuItem(link) {
			if (!link) return;
			const item = link.closest('li');
			if (item) item.classList.add('current-menu-item');
		}

		// Номер текущего хэша на странице
		let activeLink = null;

		if (currentHash) {
			activeLink = Array.from(navLinks).find(link => {
				if (link.hash && link.hash === currentHash) return true;
				try {
					const url = new URL(link.href, window.location.origin);
					return url.hash === currentHash;
				} catch (err) {
					return false;
				}
			});
		}

		if (!activeLink) {
			activeLink = Array.from(navLinks).find(link => {
				try {
					const url = new URL(link.href, window.location.origin);
					const linkPath = url.pathname.replace(/\/$/, '') || '/';
					return linkPath === currentPath;
				} catch (err) {
					return false;
				}
			});
		}

		if (!activeLink && currentHash) {
			activeLink = Array.from(navLinks).find(link => {
				return link.href === currentUrl;
			});
		}

		setMenuItem(activeLink);
	}

	// Слушаем изменение хеша
	window.addEventListener('hashchange', setActiveAnchorMenu);

	// Слушаем клики по ссылкам меню (для динамики сразу после клика)
	document.addEventListener('click', function(e) {
		const link = e.target.closest('.nav-menu a, .footer-nav a');
		if (link) {
			setTimeout(setActiveAnchorMenu, 30);
		}
	});

	// Инициализация при загрузке
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', setActiveAnchorMenu);
	} else {
		setActiveAnchorMenu();
	}
})();

/**
 * Timer Countdown
 * Создает обратный отсчет до заданной даты
 */

(function(){
	function initCountdown(el){
		if (!el) return;
		var targetAttr = el.getAttribute('data-target');
		var target = targetAttr ? new Date(targetAttr) : new Date(Date.now() + 7*24*60*60*1000);

		function update(){
			var now = new Date();
			var diff = target - now;
			if (diff < 0) diff = 0;
			var sec = Math.floor(diff/1000)%60;
			var min = Math.floor(diff/1000/60)%60;
			var hrs = Math.floor(diff/1000/60/60)%24;
			var days = Math.floor(diff/1000/60/60/24);

			var daysEl = el.querySelector('.days');
			var hoursEl = el.querySelector('.hours');
			var minutesEl = el.querySelector('.minutes');
			var secondsEl = el.querySelector('.seconds');

			if (daysEl) daysEl.textContent = days;
			if (hoursEl) hoursEl.textContent = ('0' + hrs).slice(-2);
			if (minutesEl) minutesEl.textContent = ('0' + min).slice(-2);
			if (secondsEl) secondsEl.textContent = ('0' + sec).slice(-2);
		}
		update();
		var intervalId = setInterval(update,1000);
		// store interval id in element in case we need to clear it later
		try { el._countdownInterval = intervalId; } catch(e){}
	}

	document.addEventListener('DOMContentLoaded', function(){
		var el = document.getElementById('countdown');
		if (el) initCountdown(el);
	});
})();


/**
 * Parallax Effect
 * Создает эффект параллакса для фона при скролле
 */
(function(){
	function initParallax() {
		const parallaxItems = Array.from(document.querySelectorAll('.section--parallax')).map(section => {
			const parallaxBg = section.querySelector('.parallax-bg');
			if (!parallaxBg) return null;
			parallaxBg.style.willChange = 'transform';
			return { section, parallaxBg, currentOffset: 0 };
		}).filter(Boolean);

		if (parallaxItems.length === 0) return;

		const parallaxStrength = 200;
		const easingFactor = 0.12;
		let rafId = null;

		function updateParallax() {
			const windowHeight = window.innerHeight;

			parallaxItems.forEach(item => {
				const rect = item.section.getBoundingClientRect();
				const sectionTop = rect.top;
				const sectionHeight = rect.height;
				const progress = (windowHeight - sectionTop) / (windowHeight + sectionHeight);

				const targetOffset = (progress - 0.5) * parallaxStrength;
				item.currentOffset += (targetOffset - item.currentOffset) * easingFactor;

				if (Math.abs(targetOffset - item.currentOffset) < 0.1) {
					item.currentOffset = targetOffset;
				}

				item.parallaxBg.style.transform = `translateY(${item.currentOffset}px)`;
			});

			rafId = window.requestAnimationFrame(updateParallax);
		}

		function scheduleUpdate() {
			if (rafId === null) {
				rafId = window.requestAnimationFrame(updateParallax);
			}
		}

		window.addEventListener('scroll', scheduleUpdate, { passive: true });
		window.addEventListener('resize', scheduleUpdate);

		updateParallax();
	}

	document.addEventListener('DOMContentLoaded', initParallax);
})();

 /**
 * OWL animation library
 * Аналог WOW.js для анимации при скролле
 *
 * Использование:
 *   <div class="owl" data-animation="fadeInUp" data-delay="400">
 *       <!-- содержимое -->
 *   </div>
 *
 * Параметры элемента:
 *   data-animation  - имя анимации (соответствует классам style.css, например fadeInUp, slideInLeft и т.п.)
 *   data-delay      - задержка перед запуском (в миллисекундах, по умолчанию 0)
 *
 * Опции конструктора:
 *   boxClass        - класс, по которому ищутся элементы (по умолчанию 'owl')
 *   animateClass    - класс, добавляемый при анимации (по умолчанию 'animated')
 *   offset          - как далеко от нижней границы экрана элемент должен находиться,
 *                     прежде чем анимация сработает (по умолчанию 50px)
 *   throttleTime    - минимальный интервал между проверками прокрутки (ms)
 *   delay           - глобальная задержка перед добавлением классов (ms, по умолчанию 400)
 */
class AnimaOwl {
    constructor(config = {}) {
        // Настройки
        this.boxClass = config.boxClass || 'owl';
        this.animateClass = config.animateClass || 'animated';
        this.offset = config.offset || 50;
        this.throttleTime = 100; // Задержка для оптимизации
        this.delay = config.delay || 200; // глобальная задержка перед применением класса
        this.lastScrollTime = Date.now();

        // Инициализация
        this.boxes = [];
        this.init();
    }

    init() {
        // Находим все элементы для анимации
        this.boxes = Array.from(document.getElementsByClassName(this.boxClass));

        // Первичная проверка и слушатель скролла
        this.scrollHandler();
        window.addEventListener('scroll', () => {
            // Оптимизация: не проверяем чаще, чем throttleTime
            if (Date.now() - this.lastScrollTime > this.throttleTime) {
                this.scrollHandler();
                this.lastScrollTime = Date.now();
            }
        });

        // Проверяем при изменении размера окна
        window.addEventListener('resize', () => this.scrollHandler());
    }

    scrollHandler() {
      const triggerBottom = window.innerHeight - this.offset;

      this.boxes.forEach(box => {
          const boxTop = box.getBoundingClientRect().top;
          const isVisible = boxTop < triggerBottom;
          const animationType = box.dataset.animation || 'fadeIn';

          // Удаляем классы анимации, если элемент вышел из зоны видимости
          if (!isVisible && box.classList.contains(this.animateClass)) {
              box.classList.remove(this.animateClass, animationType);
          }

          // Добавляем классы, если элемент вошел в зону видимости
          if (isVisible && !box.classList.contains(this.animateClass)) {
              // задержка перед запуском – сначала берем индивидуальную, затем глобальную
              var delay = parseInt(box.dataset.delay, 10);
              if (isNaN(delay)) delay = this.delay;
              // Небольшая дополнительная пауза (10 мс) чтобы сбросить класс
              setTimeout(() => {
                  box.classList.add(this.animateClass, animationType);
              }, delay);
          }
      });
  }
}

// Инициализация AnimaOwl при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new AnimaOwl({
        boxClass: 'owl',       // Класс для поиска
        animateClass: 'animated', // Класс-активатор
        offset: 50            // Запуск за 50px до полного появления
    });
});



/**
* Gallery Splide Initialization with Thumbnails
* Инициализирует Splide галереи с миниатюрами и синхронизацией
*/
function initGallerySplide(mainGallery) {
	const galleryId = mainGallery.getAttribute('id');
	if (!galleryId) return;

	// Находим соответствующую галерею миниатюр
	const thumbnailGallery = document.getElementById(`${galleryId}-thumbnails`);
	if (!thumbnailGallery) return;

	// Инициализируем основную галерею
	const mainSplide = new Splide(mainGallery, {
		type: 'slide',
		perPage: 1,
		perMove: 1,
		gap: 0,
		padding: 0,
		arrows: true,
		pagination: false,
		autoplay: false,
		rewind: true,
		speed: 600,
		easing: 'cubic-bezier(.42,.52,.58,.52)',
	});

	// Инициализируем галерею миниатюр
	const thumbnailSplide = new Splide(thumbnailGallery, {
		type: 'slide',
		perPage: 8,
		perMove: 1,
		gap: 8,
		pagination: false,
		autoplay: false,
		isNavigation: true,
		arrows: false,
		speed: 400,
		breakpoints: {
			992: {
				perPage: 6,
			},
			768: {
				perPage: 8,
			},
			480: {
				perPage: 6,
			}
		}
	});

	// Синхронизируем галереи
	mainSplide.sync(thumbnailSplide);

	// Обновляем активный класс миниатюры
	mainSplide.on('moved', (newIndex) => {
		const slides = thumbnailGallery.querySelectorAll('.splide__slide');
		slides.forEach((slide, index) => {
			slide.classList.toggle('is-active', index === newIndex);
		});
	});

	// Устанавливаем активный класс на первую миниатюру
	thumbnailGallery.querySelector('.splide__slide')?.classList.add('is-active');

	// Монтируем оба слайдера
	mainSplide.mount();
	thumbnailSplide.mount();

	mainGallery.classList.add('splide-initialized');
	thumbnailGallery.classList.add('splide-initialized');
}

(function() {
	'use strict';

	function initGallerySplides() {
		// Находим все галереи с Splide
		const galleries = document.querySelectorAll('.gallery__splide');

		galleries.forEach((mainGallery) => {
			initGallerySplide(mainGallery);
		});
	}

	// Инициализируем при загрузке - убрано, теперь только lazy
})();


(function() {
	'use strict';
	function logSectionIdOnClick() {
    // Создаем элемент для подсказки
    const tooltip = document.createElement('div');
    tooltip.style.cssText = `
        position: fixed;
        background: #333;
        color: #fff;
        padding: 8px 16px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 14px;
        z-index: 10000;
        opacity: 0;
				top: 45vh;
				left: 48vw;
        transition: opacity 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    `;
    document.body.appendChild(tooltip);

		// Обработчик клика на тултип
    tooltip.addEventListener('click', function(event) {
        const textToCopy = this.textContent.replace('ID: ', '/#').trim();
        navigator.clipboard.writeText(textToCopy).then(() => {
            // Меняем текст и цвет
            const originalText = this.textContent;
            const originalBg = this.style.background;

            this.textContent = '✓ Скопировано!';
            this.style.background = '#4CAF50';

            setTimeout(() => {
                this.textContent = originalText;
                this.style.background = originalBg;
            }, 1000);
        });
    });

    document.addEventListener('click', function(event) {
        if (event.ctrlKey && event.altKey) {
						event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

        const section = event.target.closest('section');
        if (!section) return;

        const id = section.id.trim() || '(no id)';

				 // Отключаем стандартное поведение (для ссылок и других элементов)
        event.preventDefault();
        event.stopPropagation();

        // Показываем подсказку
        tooltip.textContent = `ID: ${id}`;
				tooltip.style.left = event.clientX + 20 + 'px';
        tooltip.style.top = event.clientY + 20 + 'px';
        tooltip.style.opacity = '1';

        // Скрываем через 4 секунды
        setTimeout(() => {
            tooltip.style.opacity = '0';
        }, 4000);
				}

    }, true);
}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', logSectionIdOnClick);
	} else {
		logSectionIdOnClick();
	}
})();

/**
 * Fixed Header on Scroll
 * Добавляет класс 'fixed' к #header при прокрутке на 50px и более
 */
(function() {
	'use strict';

	function initFixedHeader() {
		const header = document.getElementById('header');
		if (!header) return;

		const body = document.body;
		if (body.classList.contains('home')) {
			// На домашней странице: добавляем/убираем fixed при скролле
			window.addEventListener('scroll', function() {
				if (window.scrollY > 50) {
					header.classList.add('fixed');
				} else {
					header.classList.remove('fixed');
				}
			});
		} else {
			// На всех других страницах: всегда fixed
			header.classList.add('fixed');
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initFixedHeader);
	} else {
		initFixedHeader();
	}
})();

/**
 * Background Image Setter for Data Attributes
 * Устанавливает background-image для элементов с data-bg-url-mobile и data-bg-url-desktop
 */
(function() {
	'use strict';

	function setBackgroundImages() {
		// Находим все элементы с data-bg-url-mobile или data-bg-url-desktop
		const elements = document.querySelectorAll('[data-bg-url-mobile], [data-bg-url-desktop]');

		elements.forEach(element => {
			const mobileUrl = element.getAttribute('data-bg-url-mobile');
			const desktopUrl = element.getAttribute('data-bg-url-desktop');

			function updateBackground() {
				const isDesktop = window.innerWidth >= 769;
				const url = isDesktop && desktopUrl ? desktopUrl : mobileUrl;

				if (url) {
					element.style.backgroundImage = `url('${url}')`;
				}
			}

			// Устанавливаем начальное значение
			updateBackground();

			// Обновляем при изменении размера окна
			window.addEventListener('resize', updateBackground);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', setBackgroundImages);
	} else {
		setBackgroundImages();
	}
})();

/**
 * Lazy Splide Initialization for Performance
 * Инициализирует Splide слайдеры только когда они попадают в viewport
 */
(function() {
	'use strict';

	function initLazySplide() {
		if (typeof Splide === 'undefined') return;

		const splideElements = document.querySelectorAll('.splide[data-logos-in-row], .gallery__splide');
		const observerOptions = {
			root: null,
			rootMargin: '50px',
			threshold: 0.1
		};

		const observer = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					const splideElement = entry.target;

					if (splideElement.classList.contains('gallery__splide')) {
						initGallerySplide(splideElement);
						observer.unobserve(splideElement);
						return;
					}

					if (splideElement.classList.contains('splide-initialized')) {
						observer.unobserve(splideElement);
						return;
					}

					splideElement.classList.add('splide-initialized');

					const logosInRow = parseInt(splideElement.getAttribute('data-logos-in-row'), 10);
					const rowsInSlide = parseInt(splideElement.getAttribute('data-rows-in-slide'), 10);
					const interval = parseInt(splideElement.getAttribute('data-interval'), 10) * 1000 || 3000;
					const interval_ticker = parseFloat(splideElement.getAttribute('data-interval'), 10) * 0.2 || 1;
					const ticker = splideElement.getAttribute('data-ticker') === 'true';

					if (!logosInRow || !rowsInSlide) {
						observer.unobserve(splideElement);
						return;
					}

					const numSlides = splideElement.querySelectorAll('.splide__slide').length;
					if (numSlides === 0) {
						observer.unobserve(splideElement);
						return;
					}

					const getPerPage = () => {
						const width = window.innerWidth;
						let perPage;

						if (width < 480) perPage = 2;
						else if (width < 768) perPage = 3;
						else if (width < 1200) perPage = Math.min(5, logosInRow);
						else perPage = logosInRow;

						return Math.min(perPage, numSlides);
					};

					let splideInstance;

					const createSplide = () => {
						if (ticker) {
							splideInstance = new Splide(splideElement, {
								type: 'loop',
								drag: 'free',
								focus: 'center',
								arrows: false,
								pagination: false,
								drag: true,
								keyboard: true,
								gap: 0,
								perPage: logosInRow,
								autoScroll: {
									speed: interval_ticker,
								},
								breakpoints: {
									992: {
										perPage: 4,
									},
									768: {
										perPage: 3
									},
									540: {
										perPage: 2
									}
								}
							});

							splideInstance.mount(window.splide.Extensions);

						} else {
							splideInstance = new Splide(splideElement, {
								type: numSlides > getPerPage() ? 'slide' : 'loop',
								rewind: true,
								autoplay: numSlides > getPerPage() ? true : false,
								interval: interval,
								lazyLoad: 'nearby',
								perPage: getPerPage(),
								perMove: 1,
								pagination: false,
								arrows: numSlides > getPerPage() ? true : false,
								drag: true,
								keyboard: true,
								gap: 0,
								breakpoints: {
									992: {
										perPage: Math.min(4, numSlides)
									},
									768: {
										perPage: Math.min(3, numSlides)
									},
									540: {
										perPage: Math.min(2, numSlides)
									}
								}

							});

							splideInstance.mount();
						}
					};

					createSplide();

					window.addEventListener('resize', () => {
						splideInstance.destroy();
						createSplide();
					});

					observer.unobserve(splideElement);
				}
			});
		}, observerOptions);

		splideElements.forEach(element => {
			observer.observe(element);
		});
	}

	// Инициализируем после загрузки страницы
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initLazySplide);
	} else {
		initLazySplide();
	}
})();

