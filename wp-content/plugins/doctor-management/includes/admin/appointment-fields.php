<?php

/**
 * Appointment Details meta box (edit screen)
 *
 * Shows and saves: _full_name, _doctor_name, _email, _phone,
 * _appointment_date, _reason, _status
 */

if (! defined('ABSPATH')) {
    exit;
}

/* 1. Register the meta box */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'dpp_appointment_details',
        __('Appointment Details', 'doctor-management'),
        'dpp_render_appointment_meta_box',
        'appointment',
        'normal',
        'high'
    );
});

/* 2. Render the fields */
function dpp_render_appointment_meta_box($post)
{
    wp_nonce_field('dpp_save_appointment_meta', 'dpp_appointment_meta_nonce');

    $v = function ($key) use ($post) {
        return get_post_meta($post->ID, $key, true);
    };

    $status  = $v('_status') ? $v('_status') : 'Pending';
    $statuses = array('Pending', 'Confirmed', 'Completed', 'Cancelled');
?>
    <table class="form-table" role="presentation">
        <tr>
            <th><label for="dpp_full_name"><?php esc_html_e('Patient Name', 'doctor-management'); ?></label></th>
            <td><input type="text" class="regular-text" id="dpp_full_name" name="dpp_full_name" value="<?php echo esc_attr($v('_full_name')); ?>"></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Doctor', 'doctor-management'); ?></label></th>
            <td>
                <input type="text" class="regular-text" value="<?php echo esc_attr($v('_doctor_name')); ?>" readonly>
                <p class="description"><?php esc_html_e('Set when the patient submits the form.', 'doctor-management'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="dpp_appointment_date"><?php esc_html_e('Appointment Date', 'doctor-management'); ?></label></th>
            <td><input type="text" class="regular-text" id="dpp_appointment_date" name="dpp_appointment_date" value="<?php echo esc_attr($v('_appointment_date')); ?>"></td>
        </tr>
        <tr>
            <th><label for="dpp_email"><?php esc_html_e('Email', 'doctor-management'); ?></label></th>
            <td><input type="email" class="regular-text" id="dpp_email" name="dpp_email" value="<?php echo esc_attr($v('_email')); ?>"></td>
        </tr>
        <tr>
            <th><label for="dpp_phone"><?php esc_html_e('Phone', 'doctor-management'); ?></label></th>
            <td><input type="text" class="regular-text" id="dpp_phone" name="dpp_phone" value="<?php echo esc_attr($v('_phone')); ?>"></td>
        </tr>
        <tr>
            <th><label for="dpp_reason"><?php esc_html_e('Reason for Visit', 'doctor-management'); ?></label></th>
            <td><textarea class="large-text" rows="4" id="dpp_reason" name="dpp_reason"><?php echo esc_textarea($v('_reason')); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="dpp_status"><?php esc_html_e('Status', 'doctor-management'); ?></label></th>
            <td>
                <select id="dpp_status" name="dpp_status">
                    <?php foreach ($statuses as $s) : ?>
                        <option value="<?php echo esc_attr($s); ?>" <?php selected($status, $s); ?>><?php echo esc_html($s); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
<?php
}

/* 3. Save the fields */
add_action('save_post_appointment', function ($post_id) {

    if (
        ! isset($_POST['dpp_appointment_meta_nonce']) ||
        ! wp_verify_nonce($_POST['dpp_appointment_meta_nonce'], 'dpp_save_appointment_meta')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'dpp_full_name'        => array('_full_name', 'sanitize_text_field'),
        'dpp_appointment_date' => array('_appointment_date', 'sanitize_text_field'),
        'dpp_email'            => array('_email', 'sanitize_email'),
        'dpp_phone'            => array('_phone', 'sanitize_text_field'),
        'dpp_reason'           => array('_reason', 'sanitize_textarea_field'),
        'dpp_status'           => array('_status', 'sanitize_text_field'),
    );

    foreach ($fields as $input => $cfg) {
        if (isset($_POST[$input])) {
            update_post_meta($post_id, $cfg[0], call_user_func($cfg[1], wp_unslash($_POST[$input])));
        }
    }
});
