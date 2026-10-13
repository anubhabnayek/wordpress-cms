<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Doctor Filter Shortcode
|--------------------------------------------------------------------------
*/

function dm_doctor_filter_shortcode()
{
    ob_start();


    /*
    |--------------------------------------------------------------------------
    | Get Doctors
    |--------------------------------------------------------------------------
    */

    $doctors = get_posts(array(

        'post_type'      => 'doctor',

        'post_status'    => 'publish',

        'posts_per_page' => -1,

    ));


    /*
    |--------------------------------------------------------------------------
    | Get Specializations
    |--------------------------------------------------------------------------
    */

    $specializations = array();


    foreach ($doctors as $doctor) {

        $specialization = get_post_meta(

            $doctor->ID,

            '_doctor_specialization',

            true

        );


        if (
            !empty($specialization) &&
            !in_array(
                $specialization,
                $specializations,
                true
            )
        ) {

            $specializations[] =
                $specialization;
        }
    }


    sort($specializations);

?>


    <div class="doctor-filter">


        <!-- =========================================================
             SPECIALTY
        ========================================================== -->

        <div class="filter-group">

            <h4>
                Specialty
            </h4>


            <?php foreach (
                $specializations
                as $specialization
            ) : ?>


                <label class="check">

                    <input
                        type="checkbox"
                        class="doctor-specialization"
                        value="<?php echo esc_attr(
                                    $specialization
                                ); ?>">

                    <span>

                        <?php echo esc_html(
                            $specialization
                        ); ?>

                    </span>

                </label>


            <?php endforeach; ?>

        </div>


        <!-- =========================================================
             APPOINTMENT AVAILABLE
        ========================================================== -->

        <div class="filter-group">

            <h4>
                Appointment Available
            </h4>


            <label class="check">

                <input
                    type="checkbox"
                    id="appointment"
                    value="yes">

                <span>
                    Doctor has appointment booking available
                </span>

            </label>

        </div>


        <!-- =========================================================
             GENDER
        ========================================================== -->

        <div class="filter-group">

            <h4>
                Gender
            </h4>


            <label class="check">

                <input
                    type="radio"
                    name="gender"
                    value="no_preference"
                    checked>

                <span>
                    No Preference
                </span>

            </label>


            <label class="check">

                <input
                    type="radio"
                    name="gender"
                    value="male">

                <span>
                    Male
                </span>

            </label>


            <label class="check">

                <input
                    type="radio"
                    name="gender"
                    value="female">

                <span>
                    Female
                </span>

            </label>

        </div>


        <!-- =========================================================
             EXPERIENCE
        ========================================================== -->

        <div class="filter-group">

            <h4>
                Years of Experience
            </h4>


            <input
                type="range"
                id="experience-range"
                min="0"
                max="20"
                value="5">


            <p>

                <span id="experience-value">
                    5
                </span>

                Years

            </p>

        </div>


        <!-- =========================================================
             BUTTONS
        ========================================================== -->

        <div class="filter-buttons">

            <button
                type="button"
                id="apply-doctor-filter"
                class="apply-btn">
                Apply Filter
            </button>


            <button
                type="button"
                id="reset-doctor-filter"
                class="reset-btn">
                Reset
            </button>

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
    'doctor_filter',
    'dm_doctor_filter_shortcode'
);
