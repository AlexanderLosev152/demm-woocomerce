<?php
/**
 * Секция: актуальные акции (блок promo).
 */

$img = get_template_directory_uri() . '/assets/images';

// Бейджики скидок в макете «запечены» в сами фото, поэтому badge оставлен пустым.
$promos = array(
	array(
		'image' => $img . '/promo-1.webp',
		'badge' => '',
		'date'  => 'Акция действует до 11.11.2023',
		'title' => 'Скидка 15% на все смесители',
		'text'  => 'Предлагаем смесители для кухни, ванны, душа по низким ценам! Акция действует только на товары в наличии.',
	),
	array(
		'image' => $img . '/promo-2.webp',
		'badge' => '',
		'date'  => 'Акция действует до 30.11.2023',
		'title' => 'Осенняя распродажа санитарно-технических аксессуаров для ванной комнаты',
		'text'  => 'Большой выбор аксессуаров для ванной со скидками до 40%. Товары со скидкой отмечены в каталоге красной табличкой SALE.',
	),
	array(
		'image' => $img . '/promo-3.webp',
		'badge' => '',
		'date'  => 'Акция действует до 31.12.2023',
		'title' => 'Душевые системы по выгодным ценам!',
		'text'  => 'Душевые системы, стойки и гарнитуры по выгодным ценам. Доставка в любой регион России. Гарантия от производителя.',
	),
);
?>
<section class="promo section">
	<div class="promo__inner container">
		<div class="promo__head">
			<h2 class="promo__title">Актуальные акции</h2>
			<a class="promo__all" href="#">Все акции</a>
		</div>

		<div class="promo__list">
			<?php foreach ( $promos as $promo ) : ?>
				<article class="promo__card">
					<div class="promo__image">
						<img src="<?php echo esc_url( $promo['image'] ); ?>"
						     alt="<?php echo esc_attr( $promo['title'] ); ?>">
						<?php if ( $promo['badge'] ) : ?>
							<span class="promo__badge"><?php echo esc_html( $promo['badge'] ); ?></span>
						<?php endif; ?>
					</div>
					<div class="promo__body">
						<span class="promo__date"><?php echo esc_html( $promo['date'] ); ?></span>
						<h3 class="promo__card-title"><?php echo esc_html( $promo['title'] ); ?></h3>
						<p class="promo__text"><?php echo esc_html( $promo['text'] ); ?></p>
						<a class="promo__link" href="#">Подробнее</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
