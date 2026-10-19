<?php
/**
 * Личный кабинет (My Account) — общий каркас страницы.
 *
 * Переопределение: yourtheme/woocommerce/myaccount/my-account.php
 *
 * Структура: слева меню разделов (navigation.php), справа контент раздела.
 * Кастомизация: разметка, классы, порядок блоков — здесь.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="my-account layout-with-sidebar">

	<?php
	/**
	 * Меню разделов кабинета (Заказы, Адреса, Реквизиты, Выход...).
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_navigation' );
	?>

	<div class="woocommerce-MyAccount-content my-account__content">
		<?php
		/**
		 * Контент активного раздела кабинета.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
		?>
	</div>

</div>
