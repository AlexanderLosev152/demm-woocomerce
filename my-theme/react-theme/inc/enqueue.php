<?php

function react_theme_enqueue_assets() {
    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();
    $style_path = $theme_dir . '/style.css';

    wp_enqueue_style(
        'react-theme-style',
        get_stylesheet_uri(),
        [],
        file_exists($style_path) ? (string) filemtime($style_path) : null
    );

    $dev_server = defined('MYTHEME_VITE_DEV_SERVER') ? MYTHEME_VITE_DEV_SERVER : '';
    if ($dev_server !== '') {
        $dev_server_parts = is_string($dev_server) ? wp_parse_url($dev_server) : false;
        if (
            !is_array($dev_server_parts)
            || empty($dev_server_parts['host'])
            || empty($dev_server_parts['scheme'])
            || !in_array(strtolower($dev_server_parts['scheme']), ['http', 'https'], true)
            || isset($dev_server_parts['user'])
            || isset($dev_server_parts['pass'])
        ) {
            error_log('MYTHEME_VITE_DEV_SERVER must be a valid URL string.');
            return;
        }

        $dev_server = untrailingslashit($dev_server);
        wp_enqueue_script('react-theme-vite-client', $dev_server . '/@vite/client', [], null, true);
        wp_enqueue_script('react-theme-app', $dev_server . '/src/main.jsx', [], null, true);
        react_theme_localize_script();
        return;
    }

    $manifest_path = $theme_dir . '/dist/manifest.json';
    if (!file_exists($manifest_path)) {
        error_log('React theme assets are missing. Run "npm run build" in the theme directory.');
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);
    if (!is_array($manifest)) {
        error_log('Could not parse the React theme Vite manifest at ' . $manifest_path . '.');
        return;
    }

    $entry = $manifest['src/main.jsx'] ?? null;
    if (!is_array($entry) || empty($entry['file'])) {
        error_log('The React theme Vite manifest does not contain the src/main.jsx entry.');
        return;
    }

    wp_enqueue_script(
        'react-theme-app',
        $theme_uri . '/dist/' . $entry['file'],
        [],
        null,
        true
    );
    react_theme_localize_script();

    foreach ($entry['css'] ?? [] as $index => $css_file) {
        wp_enqueue_style(
            'react-theme-vite-' . $index,
            $theme_uri . '/dist/' . $css_file,
            ['react-theme-style'],
            null
        );
    }
}
add_action('wp_enqueue_scripts', 'react_theme_enqueue_assets');

function react_theme_localize_script() {
    $hero_title = '';
    if (function_exists('get_field')) {
        $field_value = get_field('hero_title', get_queried_object_id());
        if (is_string($field_value)) {
            $hero_title = sanitize_text_field($field_value);
        }
    }

    wp_localize_script('react-theme-app', 'wpData', [
        'ajaxUrl' => esc_url_raw(admin_url('admin-ajax.php')),
        'restUrl' => esc_url_raw(rest_url()),
        'restNonce' => wp_create_nonce('wp_rest'),
        'themeUrl' => esc_url_raw(get_stylesheet_directory_uri()),
        'heroTitle' => $hero_title,
    ]);
}

function react_theme_module_script_tag($tag, $handle) {
    if (!in_array($handle, ['react-theme-vite-client', 'react-theme-app'], true)) {
        return $tag;
    }

    return str_replace('<script ', '<script type="module" ', $tag);
}
add_filter('script_loader_tag', 'react_theme_module_script_tag', 10, 2);
