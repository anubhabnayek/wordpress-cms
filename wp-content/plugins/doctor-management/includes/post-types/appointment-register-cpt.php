<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Register Appointment CPT
|--------------------------------------------------------------------------
*/
function dm_register_appointment()
{
    register_post_type('appointment', array(
        'labels' => array(
            'name'          => 'Appointments',
            'singular_name' => 'Appointment',
            'add_new'       => 'Add New',
            'add_new_item'  => 'Add New Appointment',
            'edit_item'     => 'Edit Appointment',
            'view_item'     => 'View Appointment',
            'search_items'  => 'Search Appointments',
        ),

        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'menu_icon'       => 'dashicons-calendar-alt',
        'supports'        => array('title'),
        'capability_type' => 'post',
        'map_meta_cap'    => true,
    ));
}

add_action('init', 'dm_register_appointment');
