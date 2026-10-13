<?php

/**
 * Appointment Admin Columns (fixed)
 *
 * Meta keys saved by dpp_handle_appointment():
 * _full_name, _doctor_id, _doctor_name, _email, _phone,
 * _appointment_date, _reason, _status
 */

if (! defined('ABSPATH')) {
    exit;
}

/* 1. Columns */
add_filter('manage_appointment_posts_columns', function ($columns) {
    return array(
        'cb'               => isset($columns['cb']) ? $columns['cb'] : '<input type="checkbox" />',
        'patient_name'     => __('Name', 'doctor-management'),
        'doctor'           => __('Doctor', 'doctor-management'),
        'appointment_date' => __('Appointment Date', 'doctor-management'),
        'email'            => __('Email', 'doctor-management'),
        'phone'            => __('Phone', 'doctor-management'),
        'date'             => __('Submitted Date', 'doctor-management'),
    );
});

/* 2. Column data */
add_action('manage_appointment_posts_custom_column', function ($column, $post_id) {

    switch ($column) {

        case 'patient_name':
            $name = get_post_meta($post_id, '_full_name', true);
            if (! $name) {
                $name = get_the_title($post_id);
            }
            printf(
                '<strong><a href="%s">%s</a></strong>',
                esc_url(get_edit_post_link($post_id)),
                esc_html($name)
            );
            break;

        case 'doctor':
            $doctor = get_post_meta($post_id, '_doctor_name', true);
            if (! $doctor) {
                $doctor_id = (int) get_post_meta($post_id, '_doctor_id', true);
                $doctor    = $doctor_id ? get_the_title($doctor_id) : '';
            }
            echo $doctor ? esc_html($doctor) : '—';
            break;

        case 'appointment_date':
            $date = get_post_meta($post_id, '_appointment_date', true);
            echo $date ? esc_html($date) : '—';
            break;

        case 'email':
            $email = get_post_meta($post_id, '_email', true);
            if ($email) {
                printf('<a href="mailto:%1$s">%1$s</a>', esc_attr($email));
            } else {
                echo '—';
            }
            break;

        case 'phone':
            $phone = get_post_meta($post_id, '_phone', true);
            if ($phone) {
                printf(
                    '<a href="tel:%1$s">%2$s</a>',
                    esc_attr($phone),
                    esc_html($phone)
                );
            } else {
                echo '—';
            }
            break;
    }
}, 10, 2);

/* 3. Sortable columns */
add_filter('manage_edit-appointment_sortable_columns', function ($columns) {
    $columns['appointment_date'] = 'appointment_date';
    $columns['doctor']           = 'doctor';
    $columns['patient_name']     = 'patient_name';
    return $columns;
});

/* 4. Sorting (maps column slug -> real meta key) */
add_action('pre_get_posts', function ($query) {

    if (! is_admin() || ! $query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'appointment') {
        return;
    }

    $map = array(
        'appointment_date' => '_appointment_date',
        'doctor'           => '_doctor_name',
        'patient_name'     => '_full_name',
    );

    $orderby = $query->get('orderby');

    if (isset($map[$orderby])) {
        $query->set('meta_key', $map[$orderby]);
        $query->set('orderby', 'meta_value');
    }
});
