<?php
/**
 * Магазин — архив товаров (каталог / главная страница магазина).
 *
 * Переопределение: yourtheme/woocommerce/archive-product.php
 *
 * Управляет выводом: хлебные крошки, счётчик товаров, сортировка,
 * сетка товаров, пагинация, «Товары не найдены».
 *
 * Кастомизация:
 *  - заголовок/баннер каталога  — блок `do_action( 'woocommerce_shop_loop_header' )`
 *  - фильтры и сортировка       — `do_action( 'woocommerce_before_shop_loop' )`
 *  - сетка товаров              — content-product.php
 *  - пагинация                  — `do_action( 'woocommerce_after_shop_loop' )`
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (открывает обёртку контента, см. global/wrapper-start.php)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * Здесь можно вывести заголовок каталога, баннер, текст описания магазина.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (закрывает обёртку контента)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * Боковая колонка в каталоге. Отключена в inc/woocommerce.php,
 * так как в теме нет sidebar.php — включите обратно там, если понадобится.
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
