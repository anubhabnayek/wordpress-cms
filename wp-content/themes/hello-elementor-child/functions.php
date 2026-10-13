<?php

if (! defined('ABSPATH')) {
    exit;
}

function hello_elementor_child_enqueue_styles()
{

    wp_enqueue_style(
        'hello-elementor-parent',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'hello-elementor-child',
        get_stylesheet_directory_uri() . '/style.css',
        array('hello-elementor-parent'),
        '1.0'
    );
}

add_action(
    'wp_enqueue_scripts',
    'hello_elementor_child_enqueue_styles'
);
