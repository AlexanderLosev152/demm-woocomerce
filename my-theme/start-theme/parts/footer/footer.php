<?php
/**
 * Подвал (блок footer).
 */

$img = get_template_directory_uri() . '/assets/images';

$catalog_menu = array(
	'Смесители',
	'Душевые системы',
	'Душевые стойки',
	'Изливы',
	'Аксессуары',
);

$client_menu = array(
	'Акции',
	'О компании',
	'Оплата и доставка',
	'Магазины',
	'Контакты',
);
?>
<footer class="footer">
	<div class="footer__inner container">
		<div class="footer__top">
			<div class="footer__col footer__col--brand">
				<a class="footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( $img . '/Logo.webp' ); ?>"
					     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</a>
				<a class="footer__whatsapp" href="#">
					<span class="footer__whatsapp-icon" aria-hidden="true"></span>
					Написать в WhatsApp
				</a>
			</div>

			<nav class="footer__col footer__col--menu">
				<h3 class="footer__heading">Каталог</h3>
				<ul class="footer__list">
					<?php foreach ( $catalog_menu as $item ) : ?>
						<li class="footer__item">
							<a class="footer__link" href="#"><?php echo esc_html( $item ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<nav class="footer__col footer__col--menu">
				<h3 class="footer__heading">Для клиента</h3>
				<ul class="footer__list">
					<?php foreach ( $client_menu as $item ) : ?>
						<li class="footer__item">
							<a class="footer__link" href="#"><?php echo esc_html( $item ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<div class="footer__col footer__col--contacts">
				<p class="footer__subscribe-text">
					Узнавайте об акциях и новостях первыми, подпишитесь на рассылку
				</p>

				<form class="footer__subscribe" action="#" method="post">
					<input class="footer__email" type="email" name="email" placeholder="Электронная почта" required>
					<button class="footer__submit" type="submit">Подписаться</button>
				</form>

				<a class="footer__phone" href="tel:+79999999999">+7 999 999-99-99</a>
				<address class="footer__address">г. Новосибирск, улица, дом, офис</address>
			</div>
		</div>

		<div class="footer__bottom">
			<span class="footer__copyright">© DEMM RUBINETTERIA 2023</span>
			<a class="footer__doc" href="#">Договор оферты</a>
			<a class="footer__doc" href="#">Пользовательское соглашение</a>
		</div>
	</div>
</footer>
