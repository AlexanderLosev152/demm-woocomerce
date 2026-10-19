<?php

function react_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'react-theme'),
    ]);
}
add_action('after_setup_theme', 'react_theme_setup');

require_once get_theme_file_path('/acf/acf.php');
require_once get_theme_file_path('/inc/enqueue.php');
