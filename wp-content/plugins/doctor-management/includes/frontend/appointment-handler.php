<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Appointment Form Handler
|--------------------------------------------------------------------------
*/

function dpp_handle_appointment()
{
    /*
    |--------------------------------------------------------------------------
    | Check Nonce
    |--------------------------------------------------------------------------
    */
    if (
        !isset($_POST['dpp_appt_nonce']) ||
        !wp_verify_nonce(
            $_POST['dpp_appt_nonce'],
            'dpp_appt'
        )
    ) {
        wp_die('Security check failed.');
    }

    /*
    |--------------------------------------------------------------------------
    | Get Doctor
    |--------------------------------------------------------------------------
    */

    $doctor_id = absint(
        $_POST['doctor_id'] ?? 0
    );
    if (!$doctor_id) {
        wp_die('Doctor not found.');
    }


    /*
    |--------------------------------------------------------------------------
    | Get Form Data
    |--------------------------------------------------------------------------
    */
    $full_name = sanitize_text_field(
        $_POST['full_name'] ?? ''
    );

    $email = sanitize_email(
        $_POST['email'] ?? ''
    );
    $phone = sanitize_text_field(
        $_POST['phone'] ?? ''
    );
    $appointment_date = sanitize_text_field(
        $_POST['appointment_date'] ?? ''
    );
    $reason = sanitize_textarea_field(
        $_POST['reason'] ?? ''
    );

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */
    if (empty($full_name)) {
        wp_die('Full name is required.');
    }
    if (!is_email($email)) {
        wp_die('Please enter a valid email.');
    }
    if (empty($appointment_date)) {
        wp_die('Appointment date is required.');
    }
    /*
    |--------------------------------------------------------------------------
    | Doctor Name
    |--------------------------------------------------------------------------
    */
    $doctor_name = get_the_title($doctor_id);
    /*
    |--------------------------------------------------------------------------
    | Save Appointment
    |--------------------------------------------------------------------------
    */
    $appointment_id = wp_insert_post(
        array(
            'post_type'   => 'appointment',
            'post_status' => 'publish',
            'post_title'  => $full_name . ' - ' . $doctor_name,
        )
    );
    if (is_wp_error($appointment_id)) {
        wp_die('Unable to save appointment.');
    }
    /*
    |--------------------------------------------------------------------------
    | Save Appointment Meta
    |--------------------------------------------------------------------------
    */
    update_post_meta(
        $appointment_id,
        '_doctor_id',
        $doctor_id
    );

    update_post_meta(
        $appointment_id,
        '_doctor_name',
        $doctor_name
    );

    update_post_meta(
        $appointment_id,
        '_full_name',
        $full_name
    );

    update_post_meta(
        $appointment_id,
        '_email',
        $email
    );

    update_post_meta(
        $appointment_id,
        '_phone',
        $phone
    );

    update_post_meta(
        $appointment_id,
        '_appointment_date',
        $appointment_date
    );

    update_post_meta(
        $appointment_id,
        '_reason',
        $reason
    );
    update_post_meta(
        $appointment_id,
        '_status',
        'Pending'
    );

    /*
    |--------------------------------------------------------------------------
    | Send Admin Email
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | Send Admin Email (HTML)
    |--------------------------------------------------------------------------
    */
    $admin_email = get_option('admin_email');
    $subject     = 'New Appointment Request - ' . $doctor_name;

    $rows = array(
        'Doctor'           => esc_html($doctor_name),
        'Appointment Date' => esc_html($appointment_date),
        'Patient Name'     => esc_html($full_name),
        'Patient Email'    => '<a href="mailto:' . esc_attr($email) . '" style="color:#2563eb;text-decoration:none;">' . esc_html($email) . '</a>',
        'Patient Phone'    => $phone
            ? '<a href="tel:' . esc_attr($phone) . '" style="color:#2563eb;text-decoration:none;">' . esc_html($phone) . '</a>'
            : '—',
        'Reason for Visit' => $reason ? nl2br(esc_html($reason)) : '—',
        'Status'           => '<span style="background:#fef3c7;color:#92400e;padding:3px 10px;border-radius:12px;font-size:13px;">Pending</span>',
    );

    $rows_html = '';
    foreach ($rows as $label => $value) {
        $rows_html .= '
            <tr>
                <td style="padding:12px 16px;width:160px;background:#f9fafb;border-bottom:1px solid #e5e7eb;font-weight:600;color:#374151;vertical-align:top;">'
            . esc_html($label) . '
                </td>
                <td style="padding:12px 16px;border-bottom:1px solid #e5e7eb;color:#111827;vertical-align:top;">'
            . $value . '
                </td>
            </tr>';
    }

    $edit_link = admin_url('post.php?post=' . $appointment_id . '&action=edit');

    $message = '
    <!DOCTYPE html>
    <html>
    <body style="margin:0;padding:24px;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb;">
            <tr>
                <td style="background:#2563eb;padding:20px 24px;color:#ffffff;font-size:20px;font-weight:bold;">
                    New Appointment Request
                </td>
            </tr>
            <tr>
                <td style="padding:0;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:15px;">
                        ' . $rows_html . '
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:20px 24px;text-align:center;">
                    <a href="' . esc_url($edit_link) . '" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 22px;border-radius:6px;font-size:14px;">
                        View Appointment
                    </a>
                </td>
            </tr>
        </table>
    </body>
    </html>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $full_name . ' <' . $email . '>',
    );

    wp_mail(
        $admin_email,
        $subject,
        $message,
        $headers
    );
    /*
    |--------------------------------------------------------------------------
    | Redirect Back
    |--------------------------------------------------------------------------
    */
    $redirect_url = add_query_arg(
        'appointment',
        'success',
        get_permalink($doctor_id)
    );

    wp_safe_redirect($redirect_url);

    exit;
}

/*
|--------------------------------------------------------------------------
| Logged-in Users
|--------------------------------------------------------------------------
*/
add_action(
    'admin_post_dpp_appt',
    'dpp_handle_appointment'
);
/*
|--------------------------------------------------------------------------
| Non Logged-in Users
|--------------------------------------------------------------------------
*/
add_action(
    'admin_post_nopriv_dpp_appt',
    'dpp_handle_appointment'
);