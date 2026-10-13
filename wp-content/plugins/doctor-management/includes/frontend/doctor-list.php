<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Doctor List Shortcode
|--------------------------------------------------------------------------
*/

function dm_doctor_list_shortcode()
{
    ob_start();


    /*
    |--------------------------------------------------------------------------
    | Get Doctors
    |--------------------------------------------------------------------------
    */

    $args = array(

        'post_type'      => 'doctor',

        'post_status'    => 'publish',

        // 5 doctors per page
        'posts_per_page' => 5,

        'paged'          => 1,

        'orderby'        => 'date',

        'order'          => 'DESC',

    );


    $doctors = new WP_Query($args);

?>


    <div
        id="doctor-results"
        class="doctor-results">


        <div class="doctor-results-header">

            <h2>
                Our Doctors
            </h2>

        </div>


        <div
            id="doctor-list-container"
            class="doctor-grid">


            <?php if ($doctors->have_posts()) : ?>


                <?php while ($doctors->have_posts()) : ?>

                    <?php $doctors->the_post(); ?>


                    <?php

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


                    $experience = get_post_meta(
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


                    <!-- =================================================
                         DOCTOR CARD
                    ================================================== -->

                    <div class="doctor-card">


                        <!-- Image -->

                        <div class="doctor-image">

                            <?php if (
                                !empty($doctor_image_url)
                            ) : ?>

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


                        <!-- Center -->

                        <div class="doctor-info">

                            <h3>
                                <?php the_title(); ?>
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
                                href="<?php the_permalink(); ?>"
                                class="view-btn">

                                View More

                            </a>

                        </div>


                        <!-- Right -->

                        <div class="doctor-meta">


                            <div class="meta-item">

                                📍

                                <?php echo esc_html(
                                    $location
                                ); ?>

                            </div>


                            <div class="meta-item">

                                💼

                                <?php echo esc_html(
                                    $experience
                                ); ?>+

                                Yrs Experience

                            </div>


                            <div class="meta-item">

                                📅

                                Tue, Wed, Thu, Fri

                            </div>


                            <div class="doctor-rating">

                                ★★★★★

                                <?php if (
                                    !empty($rating)
                                ) : ?>

                                    (
                                    <?php echo esc_html(
                                        $rating
                                    ); ?>
                                    )

                                <?php endif; ?>

                            </div>


                        </div>


                    </div>


                <?php endwhile; ?>


                <?php
                /*
                |--------------------------------------------------------------------------
                | Pagination
                |--------------------------------------------------------------------------
                */

                $total_pages = $doctors->max_num_pages;


                if ($total_pages > 1) :
                ?>

                    <div class="doctor-pagination">


                        <?php for (
                            $i = 1;
                            $i <= $total_pages;
                            $i++
                        ) : ?>


                            <button
                                type="button"
                                class="doctor-page-btn <?php echo (
                                                            $i === 1
                                                        ) ? 'active' : ''; ?>"
                                data-page="<?php echo esc_attr(
                                                $i
                                            ); ?>">

                                <?php echo esc_html($i); ?>

                            </button>


                        <?php endfor; ?>


                    </div>

                <?php endif; ?>


                <?php wp_reset_postdata(); ?>


            <?php else : ?>


                <div class="no-doctors">

                    <p>
                        No doctors found.
                    </p>

                </div>


            <?php endif; ?>


        </div>


    </div>


<?php

    return ob_get_clean();
}


/*
|--------------------------------------------------------------------------
| Register Shortcode
|--------------------------------------------------------------------------
*/

add_shortcode(
    'doctor_list',
    'dm_doctor_list_shortcode'
);
