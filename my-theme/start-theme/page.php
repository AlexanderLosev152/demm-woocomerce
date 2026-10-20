<?php
/**
 * Обычная страница. Используется в том числе для страниц WooCommerce,
 * созданных штатно: Корзина, Оформление заказа, Личный кабинет.
 */

$is_wc_page = function_exists('is_woocommerce') && is_woocommerce();
?>

<?php get_header() ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <main id="main" class="site-main container<?php echo $is_wc_page ? ' woocommerce-page' : ''; ?>">

            <?php if (get_the_title()) : ?>
                <header class="page-header entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="page-content entry-content">
                <?php
                if ($is_wc_page && !trim(get_the_content())) {
                    // На страницах WooCommerce без контента отдаём вывод WooCommerce.
                    woocommerce_content();
                } else {
                    the_content();
                }
                ?>
            </div>

        </main>
    <?php endwhile; ?>
<?php else : ?>
    <main id="main" class="site-main container">
        <p>Записей не найдено.</p>
    </main>
<?php endif; ?>

<?php get_footer(); ?>
