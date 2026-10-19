<?php
/**
 * Корзина — сообщение о пустой корзине.
 *
 * Переопределение: yourtheme/woocommerce/cart/cart-empty.php
 *
 * Кастомизация: текст «Корзина пуста», кнопка возврата в магазин,
 * блок рекомендаций вместо неё.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php
			/**
			 * Текст кнопки возврата в магазин.
			 *
			 * @since 4.6.0
			 * @param string $default_text Текст по умолчанию.
			 */
			echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );
			?>
		</a>
	</p>
<?php endif; ?>
