<?php

$catalog_menu = get_terms(array(
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'parent' => 0,
	'orderby' => 'menu_order',
	'order' => 'ASC',
));

?>


<header class="header">
	<div class="header__top">
		<div class="header__top-wrapper container">
			<?php wp_nav_menu(array(
				'theme_location' => 'header__top-menu',
				'container' => 'nav',
				'menu_class' => 'header__top-main-menu',
				'fallback_cb' => false,
			));

			?>

			<a class="header__user-link" href="#">
				<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M18.3346 19.25V17.4167C18.3346 16.4442 17.9483 15.5116 17.2607 14.8239C16.5731 14.1363 15.6404 13.75 14.668 13.75H7.33464C6.36217 13.75 5.42954 14.1363 4.74191 14.8239C4.05428 15.5116 3.66797 16.4442 3.66797 17.4167V19.25"
						stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#213F74"/>
					<path
						d="M14.6654 6.41667C14.6654 8.44171 13.0237 10.0833 10.9987 10.0833C8.97365 10.0833 7.33203 8.44171 7.33203 6.41667C7.33203 4.39162 8.97365 2.75 10.9987 2.75C13.0237 2.75 14.6654 4.39162 14.6654 6.41667Z"
						stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#213F74"/>
				</svg>
				Личный кабинет
			</a>
		</div>
	</div>

	<div class="header__bottom container">
		<div class="header__logo">
			<?php
			if (has_custom_logo()) {
				$custom_logo_id = get_theme_mod('custom_logo');
				$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
				?>
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img src="<?php echo esc_url($logo[0]); ?>"
					     alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
				</a>
				<?php
			} else {
				?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
					<?php bloginfo('name'); ?>
				</a>
				<?php
			}
			?>
		</div>
		<form class="header__search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
			<input type="text" placeholder="Поиск по сайту...">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"
					stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#213F74"/>
				<path d="M21.0004 21L16.6504 16.65" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
				      stroke="#213F74"/>
			</svg>
		</form>
		<a class="header__phone-link" href="tel:+79999999999">
			+7 999 999-99-99
			<span>Звоните с 8:10 до 18:10</span>
		</a>
		<button class="header__bottom-btn">Заказать звонок</button>

		<a class="header__user-mobile" href="#">
			<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/user-icon.webp'); ?>"
			     alt="Корзина">
		</a>

		<a class="header__basket-mobile" href="#">
			<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/basket-icon.webp'); ?>"
			     alt="Корзина">
			<span>1</span>
		</a>

		<button class="header__mobileicon" type="button" aria-label="Открыть меню">
			<span></span>
		</button>
	</div>

	<div class="header__main">
		<div class="header__main-wrapper container">
			<a class="header__stock" href="#">
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/stock-icon.webp'); ?>"
				     alt="Акции">
				Акции
			</a>

			<?php if (!is_wp_error($catalog_menu) && !empty($catalog_menu)) : ?>
				<ul class="header__main-menu">
					<?php foreach ($catalog_menu as $term) :
						$link = get_term_link($term);
						if (is_wp_error($link)) {
							continue;
						}
						?>
						<li class="header__main-item">
							<a href="<?php echo esc_url($link); ?>">
								<?php echo esc_html($term->name); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<a class="header__basket" href="#">
				<div>
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/basket.webp'); ?>"
					     alt="Корзина">
					<span>1</span>
				</div>
				Корзина
			</a>
		</div>
	</div>
</header>
