<?php
/**
 * Секция: каталог категорий (блок categories).
 */

if (!class_exists('WooCommerce')) {
    return;
}

$img = get_template_directory_uri() . '/assets/images';

// Желаемый порядок категорий по слагам
$desired_order = array(
        'faucets',
        'shower-systems',
        'shower-columns',
        'spouts',
        'accessories',
);
$product_cats = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
));
$product_cats = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
));

if (empty($product_cats) || is_wp_error($product_cats)) {
    return;
}

// Сортируем: сначала идут категории из $desired_order в нужном порядке,
// затем все остальные (по алфавиту / как пришли)
usort($product_cats, function ($a, $b) use ($desired_order) {
    $pos_a = array_search($a->slug, $desired_order, true);
    $pos_b = array_search($b->slug, $desired_order, true);

    // Если обе не в списке — сохраняем исходный порядок
    if ($pos_a === false && $pos_b === false) {
        return 0;
    }
    // Категории не из списка уходят в конец
    if ($pos_a === false) {
        return 1;
    }
    if ($pos_b === false) {
        return -1;
    }
    return $pos_a <=> $pos_b;
});
?>

<section class="categories section">
    <div class="categories__list container">
        <?php foreach ($product_cats as $cat) : ?>
            <?php
            $link = get_term_link($cat);
            $image_name = $cat->slug . '-img.webp';
            $image_url = $img . '/' . $image_name;
            $fallback = $img . '/cat-placeholder.webp';
            ?>
            <a class="categories__card" href="<?php echo esc_url($link); ?>">
                <div class="categories__image">
                    <img src="<?php echo esc_url($image_url); ?>"
                         onerror="this.onerror=null;this.src='<?php echo esc_url($fallback); ?>';"
                         alt="<?php echo esc_attr($cat->name); ?>"
                         loading="lazy">
                </div>
                <div class="categories__content">
                    <span class="categories__title"><?php echo esc_html($cat->name); ?></span>
                    <span class="categories__arrow" aria-hidden="true">
						<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
  						<path d="M0.75 0.75L5.60858 5.60858C5.68668 5.68668 5.68668 5.81332 5.60858 5.89142L0.75 10.75"
                              stroke-width="1.5" stroke-linecap="round" stroke="white"/>
						</svg>
					</span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
