<?php
/**
 * Подвал (блок footer).
 */

$img = get_template_directory_uri() . '/assets/images';

$catalog_menu = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
        'orderby' => 'menu_order',
        'order' => 'ASC',
));

if (is_wp_error($catalog_menu)) {
    $catalog_menu = array();
}

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
                <div class="footer__logo">
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

                <a class="footer__whatsapp" href="#">
                    <span class="footer__whatsapp-icon" aria-hidden="true"></span>
                    Написать в WhatsApp
                </a>
            </div>

            <nav class="footer__col footer__col--menu">
                <h3 class="footer__heading">Каталог</h3>
                <ul class="footer__list">
                    <?php foreach ($catalog_menu as $item) : ?>
                        <li class="footer__item">
                            <a class="footer__link" href="<?php echo esc_url(get_term_link($item)); ?>">
                                <?php echo esc_html($item->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <nav class="footer__col footer__col--menu">
                <h3 class="footer__heading">Для клиента</h3>
                <a href="#">Акции</a>
                <?php wp_nav_menu(array(
                        'theme_location' => 'header__top-menu',
                        'container' => 'nav',
                        'menu_class' => 'footer__list',
                        'fallback_cb' => false,
                ));
                ?>
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
                <div class="footer__location">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/location.webp'); ?>"
                         alt="г. Новосибирск, улица, дом, офис">
                    <address class="footer__address">г. Новосибирск, улица, дом, офис</address>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <span class="footer__copyright">© DEMM RUBINETTERIA 2023</span>
            <a class="footer__doc" href="#">Договор оферты</a>
            <a class="footer__doc" href="#">Пользовательское соглашение</a>
        </div>
    </div>
</footer>
