<?php
/**
 * Секция: форма обратной связи (блок contact).
 */

$img = get_template_directory_uri() . '/assets/images';
?>
<section class="contact section">
	<div class="contact__bg">
		<img src="<?php echo esc_url( $img . '/form-bg.webp' ); ?>" alt="">
	</div>

	<div class="contact__inner container">
		<div class="contact__wrapper">
			<img class="contact__icon" src="<?php echo esc_url( $img . '/logo-icon.webp' ); ?>" alt="" class="contact__illustration">

			<h2 class="contact__title">Остались вопросы?</h2>
			<p class="contact__descr">
				Заполните форму, мы свяжемся с вами в ближайшее время, ответим на все вопросы и предоставим
				консультацию по ассортименту.
			</p>

			<form class="contact__form" action="#" method="post">
				<div class="contact__fields">
					<label class="contact__field">
						<input class="contact__input" type="text" name="name" placeholder="Ваше имя" required>
					</label>
					<label class="contact__field">
    				<label class="contact__field">
    					<input class="contact__input" 
          			type="tel" 
          			name="phone" 
          			placeholder="Номер телефона" 
          			id="phone-input"
          			required>
					</label>
				</div>

				<label class="checkbox">
  				<input type="checkbox" name="agreement" class="checkbox__input" required>
  				<span class="checkbox__box"></span>
  				<span class="checkbox__text">
    				Я согласен(а) с <a href="#" target="_blank">Политикой конфиденциальности</a>.
  				</span>
				</label>

				<button class="contact__submit" type="submit">Оставить заявку</button>
			</form>
		</div>
		

		
	</div>
</section>
