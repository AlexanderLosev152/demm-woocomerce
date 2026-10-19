<?php

function react_theme_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_react_theme_page_content',
        'title' => __('React page content', 'react-theme'),
        'fields' => [
            [
                'key' => 'field_react_theme_hero_title',
                'label' => __('React heading', 'react-theme'),
                'name' => 'hero_title',
                'type' => 'text',
                'instructions' => __('Displayed as the main heading in the React application.', 'react-theme'),
                'required' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
        ],
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ]);
}
add_action('acf/init', 'react_theme_register_acf_fields');