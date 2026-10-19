<?php

function register_my_custom_menu() {
    register_nav_menus( array(
        'header__top-menu' => __( 'Главное меню в шапке', 'your-theme-textdomain' ),
    ) );
}
add_action( 'after_setup_theme', 'register_my_custom_menu' );
