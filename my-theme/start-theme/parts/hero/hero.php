<?php
/**
 * Секция: главный баннер (блок hero) — слайдер на Swiper.
 */

$img = get_template_directory_uri() . '/assets/images';
$title = 'Изысканные смесители для вашего интерьера';
$text = 'Гарантируем высококачественную безопасность и надёжность в соответствии с международными стандартами качества.';

$slides = array(
	array(
		'image' => $img . '/hero-1.webp',
	),
	array(
		'image' => $img . '/hero-2.webp',
	),
	array(
		'image' => $img . '/hero-3.webp',
	),
	array(
		'image' => $img . '/hero-4.webp',
	),
	array(
		'image' => $img . '/hero-5.webp',
	),
);
?>
<section class="hero swiper ">
		<div class="hero__wrapper container">
			<div class="hero__content">
				<a class="hero__link" href="#">Перейти в каталог</a>
				<h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>
				<p class="hero__text"><?php echo esc_html( $text ); ?></p>
			</div>
			<div class="hero__pagination swiper-pagination"></div>
		</div>
		
	
	<div class="hero__swiper swiper-wrapper">
		<?php foreach ( $slides as $slide ) : ?>
			<div class="hero__slide swiper-slide">
				<div class="hero__bg">
					<img class="hero__image" src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo $title ?>">
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	
</section>
