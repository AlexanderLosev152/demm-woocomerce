# WooCommerce — шаблоны страниц (папка `woocommerce`)

Переопределения шаблонов WooCommerce для темы **start-theme**.
Любой файл здесь имеет приоритет над одноимённым файлом в плагине
`wp-content/plugins/woocommerce/templates/`.

> ⚠️ Папка должна называться **именно `woocommerce`** — по этому имени
> плагин ищет переопределения. Имя вида `woocomerce` не сработает.

## Структура

| Страница магазина | Файл темы | Где править |
|---|---|---|
| Магазин (каталог) | `archive-product.php` | заголовок, баннер, сортировка, пагинация |
| Карточка товара в каталоге | `content-product.php` | картинка, название, рейтинг, цена, кнопка |
| Страница товара | `single-product.php` | каркас страницы товара |
| Корзина | `cart/cart.php` | таблица, промокод, кнопки, итоги |
| Пустая корзина | `cart/cart-empty.php` | сообщение + кнопка «Вернуться в магазин» |
| Оформление заказа | `checkout/form-checkout.php` | две колонки + сводка заказа |
| Оплата | `checkout/payment.php` | способы оплаты + кнопка «Оплатить» |
| Заказ принят | `checkout/thankyou.php` | «Спасибо за заказ», данные заказа |
| Личный кабинет | `myaccount/my-account.php` | меню слева, контент справа |
| Меню кабинета | `myaccount/navigation.php` | список разделов |
| Обёртка контента | `global/wrapper-start.php`, `global/wrapper-end.php` | контейнер `<main class="... container">` |

## Подключение и настройки

`inc/woocommerce.php` (подключён из `functions.php`):

- `add_theme_support( 'woocommerce' )` — ширины картинок, сетка каталога;
- `add_theme_support( 'wc-product-gallery-*' )` — зум, лайтбокс, слайдер галереи;
- отключена боковая колонка (в теме нет `sidebar.php`) — вернуть строкой
  `add_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );`;
- заголовок главной страницы магазина;
- 12 товаров на странице, 4 колонки в сетке.

## Страницы в базе

| Страница | Слаг | Содержимое |
|---|---|---|
| Магазин | `shop` | архив товаров CPT `product` (контент не нужен) |
| Корзина | `cart` | `[woocommerce_cart]` |
| Оформление заказа | `checkout` | `[woocommerce_checkout]` |
| Личный кабинет | `my-account` | `[woocommerce_my_account]` |
| Заказ принят | `checkout/order-received/` | endpoint оформления заказа, отдельная страница не нужна |

Раньше Корзина и Оформление заказа были на **Cart/Checkout блоках**
(`<!-- wp:woocommerce/cart -->`), из-за чего `cart/cart.php`,
`checkout/form-checkout.php`, `checkout/payment.php` не использовались.
Страницы переведены на классические шоткоды. Оригинальный блочный
контент сохранён в `../../backup-block-pages-cart-checkout.txt`
(в проекте starter-wordpress-main) — если понадобится вернуть:

```sql
UPDATE wp_posts SET post_content = '<оригинальный блочный разметка>'
WHERE ID = 8;  -- корзина
UPDATE wp_posts SET post_content = '<оригинальный блочный разметка>'
WHERE ID = 9;  -- оформление заказа
```

## Как добавить свою страницу магазина

1. Создайте страницу в админке (Консоль → Страницы → Добавить).
2. Если это новый раздел кабинета — зарегистрируйте endpoint в
   `inc/woocommerce.php`:

```php
add_filter( 'woocommerce_account_menu_items', function ( $items ) {
    $items['my-section'] = 'Мой раздел';
    return $items;
} );
add_action( 'init', function () {
    add_rewrite_endpoint( 'my-section', EP_ROOT | EP_PAGES );
} );
add_action( 'woocommerce_account_my-section_endpoint', function () {
    echo '<h2>Мой раздел</h2>';
} );
```

## Важно про обновления

Переопределённые шаблоны помечены `@version`. После обновления WooCommerce
проверьте **WooCommerce → Состояние → Шаблоны**: если версия в плагине
новее, чем в теме — перенесите изменения в актуальный файл.
