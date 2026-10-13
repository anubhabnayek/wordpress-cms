<?php

/*
Plugin Name: Doctor Management
Description: Doctor Management Custom Plugin
Version: 1.0
Author: Anubhab
*/

if (!defined('ABSPATH')) {
    exit;
}
/*
/*
|--------------------------------------------------------------------------
| Enqueue CSS & JavaScript
|--------------------------------------------------------------------------
*/
function dm_enqueue_doctor_assets()
{
    /*
    | Bootstrap CSS
    */
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );
    /*
    | Doctor List CSS
    */
    wp_enqueue_style(
        'doctor-list-css',
        plugin_dir_url(__FILE__) . 'public/css/doctor-list.css',
        array(),
        '1.0'
    );

    /*
    | Single Doctor CSS
    */
    wp_enqueue_style(
        'single-doctor-css',
        plugin_dir_url(__FILE__) . 'public/css/single-doctor.css',
        array(),
        '1.0'
    );

    /*
    | Bootstrap JS
    */
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.3',
        true
    );

    /*
    | Doctor Filter JS
    */
    wp_enqueue_script(
        'doctor-filter-js',
        plugin_dir_url(__FILE__) . 'public/js/doctor-filter.js',
        array('jquery'),
        '1.0',
        true
    );

    /*
    | AJAX Data
    */
    wp_localize_script(
        'doctor-filter-js',
        'dmDoctorAjax',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce(
                'dm_doctor_filter_nonce'
            ),
        )
    );
}

add_action(
    'wp_enqueue_scripts',
    'dm_enqueue_doctor_assets'
);


/*
|--------------------------------------------------------------------------
| Include Plugin Files
|--------------------------------------------------------------------------
*/
require_once plugin_dir_path(__FILE__) . 'includes/post-types/doctor-register-cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/post-types/appointment-register-cpt.php';

require_once plugin_dir_path(__FILE__) . 'includes/admin/doctor-fields.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin/appointment-fields.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend/doctor-list.php';

require_once plugin_dir_path(__FILE__) . 'includes/frontend/doctor-filter.php';

require_once plugin_dir_path(__FILE__) . 'includes/frontend/appointment-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin/appointment-column.php';

require_once plugin_dir_path(__FILE__) . 'includes/frontend/doctor-ajax.php';


/*
|--------------------------------------------------------------------------
| Single Doctor Template
|--------------------------------------------------------------------------
*/

function dm_load_single_doctor_template($template)
{
    if (is_singular('doctor')) {

        $plugin_template =
            plugin_dir_path(__FILE__) .
            'includes/single-doctor.php';

        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}

add_filter(
    'single_template',
    'dm_load_single_doctor_template'
);
