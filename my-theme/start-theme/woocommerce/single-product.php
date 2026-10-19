<?php
/**
 * Страница товара (один товар) — каркас.
 *
 * Переопределение: yourtheme/woocommerce/single-product.php
 *
 * Кастомизация разметки страницы товара — здесь.
 * Внутри галерея, цена, кнопка «В корзину», описание, табы,
 * связанные товары — это content-single-product.php и хуки ниже.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (открывает обёртку, см. global/wrapper-start.php)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (закрывает обёртку)
	 */
	do_action( 'woocommerce_after_main_content' );
	?>

	<?php
	/**
	 * woocommerce_sidebar hook.
	 *
	 * Отключён в inc/woocommerce.php (в теме нет sidebar.php).
	 */
	do_action( 'woocommerce_sidebar' );
	?>

<?php
get_footer( 'shop' );
