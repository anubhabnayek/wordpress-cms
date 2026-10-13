<?php

if (!defined('ABSPATH')) {
    exit;
}

function dm_register_doctor() {

    register_post_type('doctor', array(
        'labels' => array(
            'name' => 'Doctors',
            'singular_name' => 'Doctor',
            'add_new' => 'Add New Doctor',
            'add_new_item' => 'Add New Doctor',
            'edit_item' => 'Edit Doctor',
            'new_item' => 'New Doctor',
            'view_item' => 'View Doctor',
            'search_items' => 'Search Doctors',
        ),

        'public' => true,

        'menu_icon' => 'dashicons-admin-users',

        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ),

        'has_archive' => true,

        'rewrite' => array(
            'slug' => 'doctors'
        ),
    ));
}

add_action('init', 'dm_register_doctor');

?>