<?php

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Add Doctor Meta Box
|--------------------------------------------------------------------------
*/

function dm_add_doctor_meta_box()
{
    add_meta_box(
        'doctor_information',
        'Doctor Information',
        'dm_doctor_information_callback',
        'doctor',
        'normal',
        'high'
    );
}

add_action(
    'add_meta_boxes',
    'dm_add_doctor_meta_box'
);


/*
|--------------------------------------------------------------------------
| Doctor Meta Box
|--------------------------------------------------------------------------
*/

function dm_doctor_information_callback($post)
{
    /*
    |--------------------------------------------------------------------------
    | Nonce
    |--------------------------------------------------------------------------
    */

    wp_nonce_field(
        'dm_save_doctor_information',
        'dm_doctor_nonce'
    );


    /*
    |--------------------------------------------------------------------------
    | Get Existing Fields
    |--------------------------------------------------------------------------
    */

    $specialization = get_post_meta(
        $post->ID,
        '_doctor_specialization',
        true
    );

    $experience = get_post_meta(
        $post->ID,
        '_doctor_experience',
        true
    );

    $hospital = get_post_meta(
        $post->ID,
        '_doctor_hospital',
        true
    );

    $fee = get_post_meta(
        $post->ID,
        '_doctor_fee',
        true
    );

    $available_date = get_post_meta(
        $post->ID,
        '_doctor_available_date',
        true
    );

    $phone = get_post_meta(
        $post->ID,
        '_doctor_phone',
        true
    );

    $email = get_post_meta(
        $post->ID,
        '_doctor_email',
        true
    );
    $location = get_post_meta(
        $post->ID,
        '_doctor_location',
        true
    );

    $rating = get_post_meta(
        $post->ID,
        '_doctor_rating',
        true
    );


    /*
    |--------------------------------------------------------------------------
    | Get Doctor Image
    |--------------------------------------------------------------------------
    */

    $image_id = get_post_meta(
        $post->ID,
        '_doctor_image',
        true
    );

    $image_url = '';

    if (!empty($image_id)) {

        $image_url = wp_get_attachment_image_url(
            absint($image_id),
            'medium'
        );
    }

?>

    <!-- ================================================================
         SPECIALIZATION
    ================================================================= -->

    <p>

        <label>
            <strong>Specialization</strong>
        </label>

        <br>

        <input
            type="text"
            name="doctor_specialization"
            value="<?php echo esc_attr($specialization); ?>"
            style="width:100%;">

    </p>


    <!-- ================================================================
         EXPERIENCE
    ================================================================= -->

    <p>

        <label>
            <strong>Experience (Years)</strong>
        </label>

        <br>

        <input
            type="number"
            name="doctor_experience"
            value="<?php echo esc_attr($experience); ?>"
            min="0"
            style="width:100%;">

    </p>


    <!-- ================================================================
         HOSPITAL
    ================================================================= -->

    <p>

        <label>
            <strong>Hospital</strong>
        </label>

        <br>

        <input
            type="text"
            name="doctor_hospital"
            value="<?php echo esc_attr($hospital); ?>"
            style="width:100%;">

    </p>

    <!-- ================================================================
     LOCATION
================================================================= -->

    <p>
        <label>
            <strong>Location</strong>
        </label>
        <br>

        <input
            type="text"
            name="doctor_location"
            value="<?php echo esc_attr($location); ?>"
            placeholder="San Francisco"
            style="width:100%;">
    </p>
    <!-- ================================================================
         FEE
    ================================================================= -->

    <p>

        <label>
            <strong>Consultation Fee</strong>
        </label>

        <br>

        <input
            type="number"
            name="doctor_fee"
            value="<?php echo esc_attr($fee); ?>"
            min="0"
            style="width:100%;">

    </p>

    <!-- ================================================================
     RATING
================================================================= -->

    <p>
        <label>
            <strong>Rating Count</strong>
        </label>
        <br>

        <input
            type="number"
            name="doctor_rating"
            value="<?php echo esc_attr($rating); ?>"
            min="0"
            placeholder="58"
            style="width:100%;">

        <small>Example: 58 → ★★★★★ (58)</small>
    </p>
    <!-- ================================================================
         AVAILABLE DATE
    ================================================================= -->

    <p>

        <label>
            <strong>Available Date</strong>
        </label>

        <br>

        <input
            type="date"
            name="doctor_available_date"
            value="<?php echo esc_attr($available_date); ?>">

    </p>

    <!-- ================================================================
     GENDER
================================================================= -->

    <p>

        <label>
            <strong>Gender</strong>
        </label>

        <br>

        <?php
        $gender = get_post_meta(
            $post->ID,
            '_doctor_gender',
            true
        );
        ?>

        <select
            name="doctor_gender"
            style="width:100%;">

            <option value="">
                Select Gender
            </option>

            <option
                value="male"
                <?php selected($gender, 'male'); ?>>
                Male
            </option>

            <option
                value="female"
                <?php selected($gender, 'female'); ?>>
                Female
            </option>

        </select>

    </p>

    <!-- ================================================================
         PHONE
    ================================================================= -->

    <p>

        <label>
            <strong>Phone</strong>
        </label>

        <br>

        <input
            type="text"
            name="doctor_phone"
            value="<?php echo esc_attr($phone); ?>"
            style="width:100%;">

    </p>


    <!-- ================================================================
         EMAIL
    ================================================================= -->

    <p>

        <label>
            <strong>Email</strong>
        </label>

        <br>

        <input
            type="email"
            name="doctor_email"
            value="<?php echo esc_attr($email); ?>"
            style="width:100%;">

    </p>


    <!-- ================================================================
         DOCTOR IMAGE
    ================================================================= -->

    <p>
        <label>
            <strong>Doctor Image</strong>
        </label>
    </p>


    <!-- Image Preview -->

    <div
        id="doctor-image-wrapper"
        style="margin-bottom:15px;">

        <?php if (!empty($image_url)) : ?>

            <img
                src="<?php echo esc_url($image_url); ?>"
                alt="Doctor Image"
                style="
                    width:200px;
                    height:200px;
                    object-fit:cover;
                    display:block;
                ">

        <?php endif; ?>

    </div>


    <!-- Hidden Image ID -->

    <input
        type="hidden"
        name="doctor_image"
        id="doctor_image"
        value="<?php echo esc_attr($image_id); ?>">


    <!-- Select Image Button -->

    <button
        type="button"
        class="button button-primary"
        id="doctor-image-upload">
        <?php
        echo !empty($image_id)
            ? 'Change Image'
            : 'Select Image';
        ?>
    </button>


    <!-- Remove Image Button -->

    <button
        type="button"
        class="button"
        id="doctor-image-remove"
        style="<?php echo empty($image_id) ? 'display:none;' : ''; ?>">
        Remove Image
    </button>


    <!-- Current Image ID -->

    <p style="margin-top:10px;">

        <strong>Image ID:</strong>

        <span id="doctor-image-debug">
            <?php echo esc_html($image_id); ?>
        </span>

    </p>


<?php
}


/*
|--------------------------------------------------------------------------
| Load WordPress Media Library
|--------------------------------------------------------------------------
*/

function dm_load_media_library($hook)
{
    if (
        $hook !== 'post.php' &&
        $hook !== 'post-new.php'
    ) {
        return;
    }


    $screen = get_current_screen();


    if (
        $screen &&
        $screen->post_type === 'doctor'
    ) {

        wp_enqueue_media();
    }
}

add_action(
    'admin_enqueue_scripts',
    'dm_load_media_library'
);


/*
|--------------------------------------------------------------------------
| Doctor Image JavaScript
|--------------------------------------------------------------------------
*/

function dm_doctor_image_script()
{
    $screen = get_current_screen();

    if (
        !$screen ||
        $screen->post_type !== 'doctor'
    ) {
        return;
    }
?>

    <script>
        jQuery(document).ready(function($) {

            var mediaUploader = null;


            /*
            |--------------------------------------------------------------------------
            | Select Image
            |--------------------------------------------------------------------------
            */

            $('#doctor-image-upload').on('click', function(e) {

                e.preventDefault();


                if (mediaUploader) {

                    mediaUploader.open();

                    return;
                }


                mediaUploader = wp.media({

                    title: 'Select Doctor Image',

                    button: {
                        text: 'Use This Image'
                    },

                    library: {
                        type: 'image'
                    },

                    multiple: false

                });


                /*
                |--------------------------------------------------------------------------
                | Image Selected
                |--------------------------------------------------------------------------
                */

                mediaUploader.on('select', function() {

                    var attachment =
                        mediaUploader
                        .state()
                        .get('selection')
                        .first()
                        .toJSON();


                    console.log(
                        'Selected Image ID:',
                        attachment.id
                    );


                    console.log(
                        'Selected Image URL:',
                        attachment.url
                    );


                    /*
                    | Set hidden field
                    */

                    $('#doctor_image').val(
                        attachment.id
                    );


                    /*
                    | Show ID
                    */

                    $('#doctor-image-debug').text(
                        attachment.id
                    );


                    /*
                    | Show preview
                    */

                    $('#doctor-image-wrapper').html(

                        '<img src="' +
                        attachment.url +
                        '" ' +
                        'alt="Doctor Image" ' +
                        'style="' +
                        'width:200px;' +
                        'height:200px;' +
                        'object-fit:cover;' +
                        'display:block;' +
                        '">'

                    );


                    /*
                    | Change button
                    */

                    $('#doctor-image-upload').text(
                        'Change Image'
                    );


                    /*
                    | Show remove button
                    */

                    $('#doctor-image-remove').show();

                });


                mediaUploader.open();

            });


            /*
            |--------------------------------------------------------------------------
            | Remove Image
            |--------------------------------------------------------------------------
            */

            $('#doctor-image-remove').on('click', function(e) {

                e.preventDefault();


                $('#doctor_image').val('');


                $('#doctor-image-debug').text('');


                $('#doctor-image-wrapper').html('');


                $('#doctor-image-remove').hide();


                $('#doctor-image-upload').text(
                    'Select Image'
                );

            });

        });
    </script>

<?php
}

add_action(
    'admin_footer',
    'dm_doctor_image_script'
);


/*
|--------------------------------------------------------------------------
| Save Doctor Information
|--------------------------------------------------------------------------
*/

function dm_save_doctor_information($post_id)
{

    /*
    |--------------------------------------------------------------------------
    | Check Nonce
    |--------------------------------------------------------------------------
    */

    if (
        !isset($_POST['dm_doctor_nonce'])
    ) {
        return;
    }


    if (
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash(
                    $_POST['dm_doctor_nonce']
                )
            ),
            'dm_save_doctor_information'
        )
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Autosave
    |--------------------------------------------------------------------------
    */

    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Revision
    |--------------------------------------------------------------------------
    */

    if (
        wp_is_post_revision($post_id)
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check Post Type
    |--------------------------------------------------------------------------
    */

    if (
        get_post_type($post_id) !== 'doctor'
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check Permission
    |--------------------------------------------------------------------------
    */

    if (
        !current_user_can(
            'edit_post',
            $post_id
        )
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Specialization
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_specialization'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_specialization',
            sanitize_text_field(
                wp_unslash(
                    $_POST['doctor_specialization']
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Experience
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_experience'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_experience',
            absint(
                $_POST['doctor_experience']
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Hospital
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_hospital'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_hospital',
            sanitize_text_field(
                wp_unslash(
                    $_POST['doctor_hospital']
                )
            )
        );
    }
    /* ------------------------------------------------------------------
| Location
-------------------------------------------------------------------*/

    if (isset($_POST['doctor_location'])) {

        update_post_meta(
            $post_id,
            '_doctor_location',
            sanitize_text_field(
                wp_unslash($_POST['doctor_location'])
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Fee
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_fee'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_fee',
            absint(
                $_POST['doctor_fee']
            )
        );
    }

    /* ------------------------------------------------------------------
| Rating
-------------------------------------------------------------------*/

    if (isset($_POST['doctor_rating'])) {

        update_post_meta(
            $post_id,
            '_doctor_rating',
            absint($_POST['doctor_rating'])
        );
    }

    /* ------------------------------------------------------------------
| Gender
-------------------------------------------------------------------*/

    if (isset($_POST['doctor_gender'])) {

        update_post_meta(
            $post_id,
            '_doctor_gender',
            sanitize_text_field(
                wp_unslash(
                    $_POST['doctor_gender']
                )
            )
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Available Date
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_available_date'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_available_date',
            sanitize_text_field(
                wp_unslash(
                    $_POST['doctor_available_date']
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Phone
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_phone'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_phone',
            sanitize_text_field(
                wp_unslash(
                    $_POST['doctor_phone']
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_email'])
    ) {

        update_post_meta(
            $post_id,
            '_doctor_email',
            sanitize_email(
                wp_unslash(
                    $_POST['doctor_email']
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Doctor Image
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['doctor_image'])
    ) {

        $image_id = absint(
            $_POST['doctor_image']
        );


        /*
        |--------------------------------------------------------------------------
        | Image Selected
        |--------------------------------------------------------------------------
        */

        if ($image_id > 0) {

            /*
            | Save custom meta
            */

            update_post_meta(
                $post_id,
                '_doctor_image',
                $image_id
            );


            /*
            | Also set as Featured Image
            */

            set_post_thumbnail(
                $post_id,
                $image_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Image Removed
        |--------------------------------------------------------------------------
        */ else {

            delete_post_meta(
                $post_id,
                '_doctor_image'
            );


            delete_post_thumbnail(
                $post_id
            );
        }
    }
}

add_action(
    'save_post_doctor',
    'dm_save_doctor_information'
);
