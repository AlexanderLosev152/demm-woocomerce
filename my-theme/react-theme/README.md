# React Theme

Классическая тема WordPress с React-приложением: React отвечает за весь интерфейс сайта, PHP предоставляет WordPress-оболочку и серверные API. Сборка фронтенда выполняется Vite.

## Разработка

1. В `wp-config.php` добавьте перед строкой `/* That's all, stop editing! */`:

   ```php
   define('MYTHEME_VITE_DEV_SERVER', 'http://localhost:5173');
   ```

2. В каталоге темы запустите Vite:

   ```sh
   npm run dev
   ```

3. Откройте сайт WordPress в браузере. Для завершения разработки удалите константу из `wp-config.php`; без неё тема подключает production-сборку.

Если WordPress открыт в браузере не на той же машине, где работает Vite, укажите в константе доступный браузеру адрес dev-сервера.

## Production

В каталоге темы выполните:

```sh
npm run build
```

Затем разверните тему вместе с каталогом `dist`. PHP загружает файлы из `dist/manifest.json`; каталог `dist` не хранится в репозитории.

## React-приложение

WordPress-шаблон `index.php` предоставляет единственный элемент монтирования:

```html
<div id="root"></div>
```

`src/main.jsx` монтирует компонент `App` в этот элемент. Разметку и страницы сайта реализуйте в React, начиная с `src/App.jsx`; PHP-шаблоны оставляйте для системной WordPress-оболочки.

PHP передаёт фронтенду `window.wpData` с URL REST API, nonce, URL AJAX и URL темы. WooCommerce-данные добавляйте отдельно только там, где они нужны, и проверяйте доступность соответствующего плагина.

## ACF

Установите и активируйте плагин Advanced Custom Fields. Группа полей зарегистрирована в `acf/acf.php`: на страницах появится поле `React page content → React heading` (имя поля `hero_title`). Его значение передаётся в `window.wpData.heroTitle`. Если поле пустое, React покажет текст-заполнитель из `src/App.jsx`.
