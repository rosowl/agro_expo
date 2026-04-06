<?php get_header(); ?>
<style>
	/* Скидання для чистого інтегрування у WP (без впливу на глобальні стилі) */
	.agro-404-wrapper {
		display: flex;
		align-items: center;
		justify-content: center;
		min-height: calc(100vh - 560px);
		box-sizing: border-box;
		margin: 0;
	}

	/* Головна картка — легка, без зайвих ефектів */
	.agro-card {
		max-width: 500px;
		width: 100%;
		background: #fffef7;
		border-radius: 48px 32px 48px 32px;
		box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.02);
		text-align: center;
		padding: 2rem 1.8rem;
		transition: all 0.2s ease;
		border: 1px solid #f3e5b5;
	}

	/* Мінімалістичний агро-декор */
	.agro-icon {
		font-size: 4rem;
		line-height: 1;
		margin-bottom: 0.5rem;
		display: inline-block;
		filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.1));
	}

	.number-404 {
		font-size: 5rem;
		font-weight: 800;
		line-height: 1.1;
		background: linear-gradient(125deg, #5d8233, #b47c44);
		background-clip: text;
		-webkit-background-clip: text;
		color: transparent;
		letter-spacing: 2px;
		margin: 0.2rem 0 0.2rem 0;
	}

	.agro-title {
		font-size: 1.6rem;
		font-weight: 700;
		color: #3c5e2b;
		margin: 0.5rem 0 0.25rem;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		flex-wrap: wrap;
	}

	.agro-divider {
		width: 70px;
		height: 3px;
		background: #dbbc7c;
		margin: 0.8rem auto;
		border-radius: 20px;
	}

	.agro-message {
		color: #5b4a32;
		font-size: 1rem;
		background: #fef7e6;
		padding: 0.5rem 1rem;
		border-radius: 60px;
		display: inline-block;
		margin: 0.5rem 0 1.5rem;
		font-weight: 500;
		box-shadow: inset 0 0 0 1px #fff0cf, 0 1px 2px rgba(0, 0, 0, 0.02);
	}

	/* Проста кнопка повернення */
	.agro-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 12px;
		background-color: #6f9e3f;
		color: white;
		border: none;
		padding: 0.75rem 1.8rem;
		font-size: 1.1rem;
		font-weight: 600;
		border-radius: 50px;
		cursor: pointer;
		transition: all 0.2s;
		text-decoration: none;
		font-family: inherit;
		width: auto;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
	}

	.agro-btn:hover {
		background-color: #58832e;
		transform: translateY(-2px);
		box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
	}

	.agro-btn:active {
		transform: translateY(1px);
	}

	.btn-icon {
		font-size: 1.3rem;
		transition: transform 0.2s;
	}

	.agro-btn:hover .btn-icon {
		transform: translateX(4px);
	}

	/* Для дуже маленьких екранів — ще компактніше */
	@media (max-width: 550px) {
		.agro-404-wrapper {
			min-height: calc(100vh - 220px);
			padding: 0.8rem;
		}

		.agro-card {
			padding: 1.5rem 1.2rem;
			border-radius: 36px 24px 36px 24px;
		}

		.number-404 {
			font-size: 4rem;
		}

		.agro-title {
			font-size: 1.3rem;
		}

		.agro-icon {
			font-size: 3.2rem;
		}

		.agro-btn {
			padding: 0.6rem 1.4rem;
			font-size: 1rem;
		}
	}

	/* Якщо хедер/футер відсутні або дуже маленькі — сторінка без скролу */
	@media (max-height: 600px) {
		.agro-404-wrapper {
			min-height: auto;
			height: 100%;
			padding-top: 0.5rem;
			padding-bottom: 0.5rem;
		}

		.agro-card {
			padding: 1rem 1.2rem;
		}
	}
</style>
<article id="post-0" class="post not-found" role="alert">
	<div class="agro-404-wrapper">
		<div class="agro-card">
			<div class="agro-icon">🚜🌾</div>
			<div class="number-404">404</div>
			<div class="agro-title">
				<span>🌻</span> Заблукали в полі <span>🌽</span>
			</div>
			<div class="agro-divider"></div>
			<div class="agro-message">
				Такої сторінки не існує
			</div>

			<a heref="/" class="agro-btn" id="returnHomeBtn">
				<span>🌾</span>
				На головну
				<span class="btn-icon">🚜</span>
			</a>
		</div>
	</div>
</article>
<?php get_footer(); ?>