<?php
/**
 * WooCommerce: поддержка темой, обёртки, настройки каталога.
 *
 * Все шаблоны магазина лежат в папке /woocommerce этой темы:
 *
 *   woocommerce/archive-product.php      — Магазин (каталог)
 *   woocommerce/content-product.php      — карточка товара в каталоге
 *   woocommerce/single-product.php       — страница товара
 *   woocommerce/cart/cart.php            — Корзина
 *   woocommerce/cart/cart-empty.php      — пустая корзина
 *   woocommerce/checkout/form-checkout.php — Оформление заказа
 *   woocommerce/checkout/payment.php     — Оплата
 *   woocommerce/checkout/thankyou.php    — Заказ принят (после оплаты)
 *   woocommerce/myaccount/my-account.php — Личный кабинет
 *   woocommerce/myaccount/navigation.php — меню кабинета
 *   woocommerce/global/wrapper-start.php / wrapper-end.php — обёртка контента
 */

/**
 * Объявляем теме поддержку WooCommerce и галереи товара.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support(
		'woocommerce',
		array(
			// Ширина картинок — влияет на размеры, которые генерирует WP.
			'thumbnail_image_width' => 300,
			'single_image_width'    => 600,
			// Сетка каталога по умолчанию.
			'product_grid'          => array(
				'default_columns' => 4,
				'default_rows'    => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
				'min_rows'        => 1,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
} );

/**
 * Боковая колонка магазина отключена: в теме нет sidebar.php.
 * Верните строку обратно, когда добавите sidebar.php и виджет-область «shop-sidebar».
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

/**
 * Заголовок страницы магазина.
 * WooCommerce на главной странице магазина сама заголовок не выводит.
 */
add_action(
	'woocommerce_shop_loop_header',
	function () {
		if ( ! is_shop() ) {
			return;
		}
		?>
		<header class="shop-header woocommerce-header">
			<h1 class="shop-header__title"><?php echo esc_html( get_the_title( wc_get_page_id( 'shop' ) ) ); ?></h1>
		</header>
		<?php
	},
	5
);

/**
 * Товаров на странице каталога.
 */
add_filter( 'loop_shop_per_page', function () {
	return 12;
} );

/**
 * Колонок в сетке каталога.
 */
add_filter( 'loop_shop_columns', function () {
	return 4;
} );

/**
 * Хлебные крошки. Чтобы сделать свои — раскомментируйте и перенесите
 * разметку в parts/shop/breadcrumb.php:
 *
 * remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
 * add_action( 'woocommerce_before_main_content', function () {
 *     woocommerce_breadcrumb();
 * }, 20 );
 */
