<?php

/**
 * Single Doctor Details
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $doctor_id = get_the_ID();

    /*
    |--------------------------------------------------------------------------
    | Doctor Data
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

    $fee = get_post_meta(
        $doctor_id,
        '_doctor_fee',
        true
    );

    $available_date = get_post_meta(
        $doctor_id,
        '_doctor_available_date',
        true
    );

    $phone = get_post_meta(
        $doctor_id,
        '_doctor_phone',
        true
    );

    $email = get_post_meta(
        $doctor_id,
        '_doctor_email',
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

    $image_id = get_post_meta(
        $doctor_id,
        '_doctor_image',
        true
    );

    $image_url = '';

    if (!empty($image_id) && is_numeric($image_id)) {

        $image_url = wp_get_attachment_image_url(
            absint($image_id),
            'large'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Featured Image Fallback
    |--------------------------------------------------------------------------
    */

    if (
        empty($image_url) &&
        has_post_thumbnail($doctor_id)
    ) {

        $image_url = get_the_post_thumbnail_url(
            $doctor_id,
            'large'
        );
    }

?>

    <main class="doctor-detail-page">

        <!-- ==========================================================
         HERO
    =========================================================== -->

        <section class="doctor-detail-hero">

            <div class="doctor-detail-container">

                <div class="doctor-breadcrumb">

                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        Home
                    </a>

                    <span>/</span>

                    <a href="<?php echo esc_url(
                                    get_post_type_archive_link('doctor')
                                ); ?>">
                        Doctors
                    </a>

                    <span>/</span>

                    <strong>
                        <?php echo esc_html(get_the_title()); ?>
                    </strong>

                </div>

                <h1>
                    Doctor Profile
                </h1>

            </div>

        </section>


        <!-- ==========================================================
         MAIN CONTENT
    =========================================================== -->

        <div class="doctor-detail-container">

            <div class="doctor-detail-layout">


                <!-- ==================================================
                 LEFT CONTENT
            =================================================== -->

                <div class="doctor-detail-main">


                    <!-- Doctor Header -->

                    <section class="doctor-detail-card doctor-profile">

                        <!-- Image -->

                        <div class="doctor-detail-image">

                            <?php if (!empty($image_url)) : ?>

                                <img
                                    src="<?php echo esc_url($image_url); ?>"
                                    alt="<?php echo esc_attr(
                                                get_the_title()
                                            ); ?>">

                            <?php else : ?>

                                <div class="doctor-no-image">
                                    No Image
                                </div>

                            <?php endif; ?>

                        </div>


                        <!-- Information -->

                        <div class="doctor-detail-info">

                            <h2>
                                <?php echo esc_html(
                                    get_the_title()
                                ); ?>
                            </h2>


                            <?php if (!empty($specialization)) : ?>

                                <p class="doctor-specialization">

                                    <?php echo esc_html(
                                        $specialization
                                    ); ?>

                                </p>

                            <?php endif; ?>


                            <?php if (!empty($hospital)) : ?>

                                <p class="doctor-hospital">

                                    <?php echo esc_html(
                                        $hospital
                                    ); ?>

                                </p>

                            <?php endif; ?>


                            <?php if (!empty($location)) : ?>

                                <p class="doctor-location">

                                    📍
                                    <?php echo esc_html(
                                        $location
                                    ); ?>

                                </p>

                            <?php endif; ?>


                            <!-- Rating -->

                            <?php if ($rating !== '') : ?>

                                <div class="doctor-rating">

                                    <span class="stars">
                                        ★★★★★
                                    </span>

                                    <span>
                                        <?php echo esc_html(
                                            $rating
                                        ); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <!-- Meta -->

                            <div class="doctor-detail-meta">

                                <?php if (!empty($experience)) : ?>

                                    <div>

                                        <strong>
                                            Experience
                                        </strong>

                                        <span>
                                            <?php echo esc_html(
                                                $experience
                                            ); ?>
                                            Years
                                        </span>

                                    </div>

                                <?php endif; ?>


                                <?php if (!empty($available_date)) : ?>

                                    <div>

                                        <strong>
                                            Available Date
                                        </strong>

                                        <span>
                                            <?php echo esc_html(
                                                $available_date
                                            ); ?>
                                        </span>

                                    </div>

                                <?php endif; ?>


                                <?php if (!empty($fee)) : ?>

                                    <div>

                                        <strong>
                                            Consultation Fee
                                        </strong>

                                        <span>
                                            ₹<?php echo esc_html(
                                                    $fee
                                                ); ?>
                                        </span>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    </section>


                    <!-- ==================================================
                     ABOUT
                =================================================== -->

                    <section class="doctor-detail-card">

                        <h3>
                            About <?php echo esc_html(
                                        get_the_title()
                                    ); ?>
                        </h3>

                        <div class="doctor-about">

                            <?php the_content(); ?>

                        </div>

                    </section>


                    <!-- ==================================================
                     DOCTOR INFORMATION
                =================================================== -->

                    <section class="doctor-detail-card">

                        <h3>
                            Doctor Information
                        </h3>


                        <div class="doctor-information-grid">


                            <?php if (!empty($specialization)) : ?>

                                <div class="info-item">

                                    <span>
                                        Specialization
                                    </span>

                                    <strong>
                                        <?php echo esc_html(
                                            $specialization
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (!empty($hospital)) : ?>

                                <div class="info-item">

                                    <span>
                                        Hospital
                                    </span>

                                    <strong>
                                        <?php echo esc_html(
                                            $hospital
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (!empty($experience)) : ?>

                                <div class="info-item">

                                    <span>
                                        Experience
                                    </span>

                                    <strong>
                                        <?php echo esc_html(
                                            $experience
                                        ); ?>
                                        Years
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (!empty($location)) : ?>

                                <div class="info-item">

                                    <span>
                                        Location
                                    </span>

                                    <strong>
                                        <?php echo esc_html(
                                            $location
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (!empty($phone)) : ?>

                                <div class="info-item">

                                    <span>
                                        Phone
                                    </span>

                                    <strong>
                                        <?php echo esc_html(
                                            $phone
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (!empty($email)) : ?>

                                <div class="info-item">

                                    <span>
                                        Email
                                    </span>

                                    <strong>
                                        <?php echo esc_html(
                                            $email
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endif; ?>

                        </div>

                    </section>


                </div>


                <!-- ==================================================
                 RIGHT SIDEBAR
            =================================================== -->

                <aside class="doctor-detail-sidebar">


                    <!-- Appointment -->

                    <section class="doctor-detail-card">

                        <h3>
                            Book an Appointment
                        </h3>
                        <?php if (isset($_GET['appointment']) && $_GET['appointment'] === 'success') : ?>
                            <div class="dpp-alert dpp-alert-success" role="alert">
                                <strong>Appointment Request Sent!</strong>
                                Your appointment request has been submitted successfully. We will contact you shortly.
                                <button type="button" class="dpp-alert-close" aria-label="Close"
                                    onclick="this.parentElement.remove()">&times;</button>
                            </div>
                        <?php endif; ?>
                        <form
                            method="post"
                            action="<?php echo esc_url(
                                        admin_url('admin-post.php')
                                    ); ?>"
                            class="doctor-appointment-form">


                            <input
                                type="hidden"
                                name="action"
                                value="dpp_appt">

                            <input
                                type="hidden"
                                name="doctor_id"
                                value="<?php echo esc_attr(
                                            $doctor_id
                                        ); ?>">


                            <?php wp_nonce_field(
                                'dpp_appt',
                                'dpp_appt_nonce'
                            ); ?>


                            <label>
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                placeholder="Your name"
                                required>


                            <label>
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                placeholder="you@example.com"
                                required>


                            <label>
                                Phone
                            </label>

                            <input
                                type="tel"
                                name="phone"
                                placeholder="Your phone">


                            <label>
                                Appointment Date
                            </label>

                            <input
                                type="date"
                                name="appointment_date"
                                value="<?php echo esc_attr(
                                            $available_date
                                        ); ?>">


                            <label>
                                Reason for Visit
                            </label>

                            <textarea
                                name="reason"
                                rows="4"
                                placeholder="Briefly describe your reason"></textarea>


                            <button type="submit">
                                Request Appointment
                            </button>

                        </form>

                    </section>


                    <!-- Consultation Fee -->

                    <section class="doctor-detail-card">

                        <h3>
                            Consultation Fee
                        </h3>

                        <?php if (!empty($fee)) : ?>

                            <div class="fee-row">

                                <span>
                                    Consultation
                                </span>

                                <strong>
                                    ₹<?php echo esc_html(
                                            $fee
                                        ); ?>
                                </strong>

                            </div>

                        <?php endif; ?>

                    </section>


                    <!-- Contact -->

                    <section class="doctor-detail-card">

                        <h3>
                            Contact Doctor
                        </h3>


                        <?php if (!empty($phone)) : ?>

                            <p>
                                📞
                                <?php echo esc_html(
                                    $phone
                                ); ?>
                            </p>

                        <?php endif; ?>


                        <?php if (!empty($email)) : ?>

                            <p>
                                ✉
                                <?php echo esc_html(
                                    $email
                                ); ?>
                            </p>

                        <?php endif; ?>


                        <?php if (!empty($location)) : ?>

                            <p>
                                📍
                                <?php echo esc_html(
                                    $location
                                ); ?>
                            </p>

                        <?php endif; ?>

                    </section>


                </aside>

            </div>

        </div>

    </main>

<?php
endwhile;
get_footer();
