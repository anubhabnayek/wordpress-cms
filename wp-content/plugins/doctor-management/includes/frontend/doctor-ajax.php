<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| AJAX Filter Doctors
|--------------------------------------------------------------------------
*/

function dm_ajax_filter_doctors()
{

    /*
    |--------------------------------------------------------------------------
    | Verify Nonce
    |--------------------------------------------------------------------------
    */

    check_ajax_referer(
        'dm_doctor_filter_nonce',
        'nonce'
    );


    /*
    |--------------------------------------------------------------------------
    | Specialty
    |--------------------------------------------------------------------------
    */

    $specializations = isset($_POST['specializations'])
        ? array_map(
            'sanitize_text_field',
            (array) $_POST['specializations']
        )
        : array();


    /*
    |--------------------------------------------------------------------------
    | Appointment Available
    |--------------------------------------------------------------------------
    */

    $appointment_available = isset(
        $_POST['appointment_available']
    )
        ? sanitize_text_field(
            $_POST['appointment_available']
        )
        : '';


    /*
    |--------------------------------------------------------------------------
    | Gender
    |--------------------------------------------------------------------------
    */

    $gender = isset($_POST['gender'])
        ? sanitize_text_field(
            $_POST['gender']
        )
        : '';


    /*
    |--------------------------------------------------------------------------
    | Experience
    |--------------------------------------------------------------------------
    */

    $experience = isset($_POST['experience'])
        ? intval($_POST['experience'])
        : 5;


    /*
    |--------------------------------------------------------------------------
    | Page
    |--------------------------------------------------------------------------
    */

    $paged = isset($_POST['paged'])
        ? max(
            1,
            intval($_POST['paged'])
        )
        : 1;


    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    $args = array(

        'post_type' => 'doctor',

        'post_status' => 'publish',

        'posts_per_page' => 5,

        'paged' => $paged,

        'orderby' => 'date',

        'order' => 'DESC',

    );


    /*
    |--------------------------------------------------------------------------
    | Meta Query
    |--------------------------------------------------------------------------
    */

    $meta_query = array(
        'relation' => 'AND'
    );


    /*
    |--------------------------------------------------------------------------
    | Specialty Filter
    |--------------------------------------------------------------------------
    */

    if (!empty($specializations)) {

        $meta_query[] = array(

            'key' => '_doctor_specialization',

            'value' => $specializations,

            'compare' => 'IN',

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Appointment Available
    |--------------------------------------------------------------------------
    */

    if ($appointment_available === 'yes') {

        $meta_query[] = array(

            'key' => '_doctor_available_date',

            'value' => '',

            'compare' => '!=',

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Gender Filter
    |--------------------------------------------------------------------------
    */

    if (
        !empty($gender) &&
        $gender !== 'no_preference'
    ) {

        $meta_query[] = array(

            'key' => '_doctor_gender',

            'value' => $gender,

            'compare' => '=',

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Experience Filter
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | Slider = 5
    |
    | Shows doctors with:
    |
    | 0 - 5 years experience
    |
    */

    $meta_query[] = array(

        'key' => '_doctor_experience',

        'value' => $experience,

        'type' => 'NUMERIC',

        'compare' => '<=',

    );


    /*
    |--------------------------------------------------------------------------
    | Add Meta Query
    |--------------------------------------------------------------------------
    */

    $args['meta_query'] = $meta_query;


    /*
    |--------------------------------------------------------------------------
    | Execute Query
    |--------------------------------------------------------------------------
    */

    $doctors = new WP_Query($args);


    /*
    |--------------------------------------------------------------------------
    | Start Output Buffer
    |--------------------------------------------------------------------------
    */

    ob_start();


    /*
    |--------------------------------------------------------------------------
    | Doctors Found
    |--------------------------------------------------------------------------
    */

    if ($doctors->have_posts()) :

        while ($doctors->have_posts()) :

            $doctors->the_post();


            /*
            |--------------------------------------------------------------------------
            | Doctor ID
            |--------------------------------------------------------------------------
            */

            $doctor_id = get_the_ID();


            /*
            |--------------------------------------------------------------------------
            | Doctor Fields
            |--------------------------------------------------------------------------
            */

            $specialization = get_post_meta(
                $doctor_id,
                '_doctor_specialization',
                true
            );


            $experience_value = get_post_meta(
                $doctor_id,
                '_doctor_experience',
                true
            );


            $hospital = get_post_meta(
                $doctor_id,
                '_doctor_hospital',
                true
            );


            $location = get_post_meta(
                $doctor_id,
                '_doctor_location',
                true
            );


            $rating = get_post_meta(
                $doctor_id,
                '_doctor_rating',
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Doctor Image
            |--------------------------------------------------------------------------
            */

            $doctor_image_id = get_post_meta(
                $doctor_id,
                '_doctor_image',
                true
            );


            $doctor_image_url = '';


            /*
            |--------------------------------------------------------------------------
            | Custom Image
            |--------------------------------------------------------------------------
            */

            if (
                !empty($doctor_image_id) &&
                is_numeric($doctor_image_id)
            ) {

                $doctor_image_url =
                    wp_get_attachment_image_url(
                        absint($doctor_image_id),
                        'medium'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Featured Image Fallback
            |--------------------------------------------------------------------------
            */

            if (
                empty($doctor_image_url) &&
                has_post_thumbnail($doctor_id)
            ) {

                $doctor_image_url =
                    get_the_post_thumbnail_url(
                        $doctor_id,
                        'medium'
                    );
            }

?>


            <!-- =====================================================
                 DOCTOR CARD
            ====================================================== -->

            <div class="doctor-card">


                <!-- Doctor Image -->

                <div class="doctor-image">

                    <?php if (!empty($doctor_image_url)) : ?>

                        <img
                            src="<?php echo esc_url(
                                        $doctor_image_url
                                    ); ?>"
                            alt="<?php echo esc_attr(
                                        get_the_title()
                                    ); ?>">

                    <?php else : ?>

                        <div class="doctor-no-image">
                            No Image
                        </div>

                    <?php endif; ?>

                </div>


                <!-- Doctor Information -->

                <div class="doctor-info">

                    <h3>

                        <?php echo esc_html(
                            get_the_title()
                        ); ?>

                    </h3>


                    <div class="doctor-speciality">

                        <?php echo esc_html(
                            $specialization
                        ); ?>

                    </div>


                    <div class="doctor-hospital">

                        <?php echo esc_html(
                            $hospital
                        ); ?>

                    </div>


                    <div class="doctor-campus">

                        Parnassus Campus

                    </div>


                    <a
                        href="<?php echo esc_url(
                                    get_permalink()
                                ); ?>"
                        class="view-btn">

                        View More

                    </a>

                </div>


                <!-- Doctor Meta -->

                <div class="doctor-meta">


                    <!-- Location -->

                    <div class="meta-item">

                        📍

                        <?php echo esc_html(
                            $location
                        ); ?>

                    </div>


                    <!-- Experience -->

                    <div class="meta-item">

                        💼

                        <?php echo esc_html(
                            $experience_value
                        ); ?>+

                        Yrs Experience

                    </div>


                    <!-- Available Date -->

                    <div class="meta-item">

                        📅

                        <?php

                        $available_date = get_post_meta(
                            $doctor_id,
                            '_doctor_available_date',
                            true
                        );

                        if (!empty($available_date)) {

                            echo esc_html(
                                date(
                                    'D, M d, Y',
                                    strtotime($available_date)
                                )
                            );
                        } else {

                            echo 'Not Available';
                        }

                        ?>

                    </div>


                    <!-- Rating -->

                    <div class="doctor-rating">

                        ★★★★★

                        <?php if (!empty($rating)) : ?>

                            (
                            <?php echo esc_html(
                                $rating
                            ); ?>
                            )

                        <?php endif; ?>

                    </div>


                </div>


            </div>


        <?php

        endwhile;


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $total_pages = $doctors->max_num_pages;


        if ($total_pages > 1) :

        ?>

            <div class="doctor-pagination">


                <?php

                for (
                    $i = 1;
                    $i <= $total_pages;
                    $i++
                ) :

                ?>

                    <button
                        type="button"
                        class="doctor-page-btn <?php echo (
                                                    $i === $paged
                                                )
                                                    ? 'active'
                                                    : ''; ?>"
                        data-page="<?php echo esc_attr(
                                        $i
                                    ); ?>">

                        <?php echo esc_html($i); ?>

                    </button>


                <?php endfor; ?>


            </div>


        <?php

        endif;


    /*
    |--------------------------------------------------------------------------
    | No Doctors
    |--------------------------------------------------------------------------
    */

    else :

        ?>

        <div class="no-doctors">

            <p>
                No doctors found.
            </p>

        </div>

<?php

    endif;


    /*
    |--------------------------------------------------------------------------
    | Reset Post Data
    |--------------------------------------------------------------------------
    */

    wp_reset_postdata();


    /*
    |--------------------------------------------------------------------------
    | Return AJAX Response
    |--------------------------------------------------------------------------
    */

    wp_send_json_success(
        array(

            'html' =>
            ob_get_clean(),

            'total_pages' =>
            $doctors->max_num_pages,

            'current_page' =>
            $paged,

        )
    );
}


/*
|--------------------------------------------------------------------------
| AJAX Hooks
|--------------------------------------------------------------------------
*/

add_action(
    'wp_ajax_dm_filter_doctors',
    'dm_ajax_filter_doctors'
);


add_action(
    'wp_ajax_nopriv_dm_filter_doctors',
    'dm_ajax_filter_doctors'
);
