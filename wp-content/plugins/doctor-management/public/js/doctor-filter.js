jQuery(document).ready(function ($) {

    /*
    |--------------------------------------------------------------------------
    | Load Doctors with AJAX
    |--------------------------------------------------------------------------
    */

    function loadDoctors(page = 1) {

        var specializations = [];

        $('.doctor-specialization:checked').each(function () {

            specializations.push(
                $(this).val()
            );

        });


        /*
        |--------------------------------------------------------------------------
        | Appointment Available
        |--------------------------------------------------------------------------
        */

        var appointmentAvailable = '';

        if ($('#appointment').is(':checked')) {

            appointmentAvailable = 'yes';

        }


        /*
        |--------------------------------------------------------------------------
        | Gender
        |--------------------------------------------------------------------------
        */

        var gender = $('input[name="gender"]:checked').val();

        if (
            !gender ||
            gender === 'no_preference'
        ) {

            gender = '';

        }


        /*
        |--------------------------------------------------------------------------
        | Experience
        |--------------------------------------------------------------------------
        */

        var experience = $('#experience-range').val();

        if (!experience) {

            experience = 5;

        }


        /*
        |--------------------------------------------------------------------------
        | Check AJAX Object
        |--------------------------------------------------------------------------
        */

        if (
            typeof dmDoctorAjax === 'undefined'
        ) {

            console.error(
                'dmDoctorAjax is not defined.'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        $('#doctor-list-container').html(
            '<p class="doctor-loading">Loading doctors...</p>'
        );


        /*
        |--------------------------------------------------------------------------
        | AJAX Request
        |--------------------------------------------------------------------------
        */

        $.ajax({

            url: dmDoctorAjax.ajax_url,

            type: 'POST',

            data: {

                action: 'dm_filter_doctors',

                nonce: dmDoctorAjax.nonce,

                specializations: specializations,

                appointment_available:
                    appointmentAvailable,

                gender: gender,

                experience: experience,

                paged: page

            },


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            success: function (response) {

                if (
                    response.success &&
                    response.data &&
                    response.data.html
                ) {

                    $('#doctor-list-container')
                        .html(
                            response.data.html
                        );

                } else {

                    $('#doctor-list-container')
                        .html(
                            '<p class="no-doctors">No doctors found.</p>'
                        );

                }

            },


            /*
            |--------------------------------------------------------------------------
            | Error
            |--------------------------------------------------------------------------
            */

            error: function (
                xhr,
                status,
                error
            ) {

                console.error(
                    'Doctor AJAX Error:',
                    error
                );

                console.error(
                    xhr.responseText
                );

                $('#doctor-list-container')
                    .html(
                        '<p class="no-doctors">Something went wrong. Please try again.</p>'
                    );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Apply Filter
    |--------------------------------------------------------------------------
    */

    $('#apply-doctor-filter').on(
        'click',
        function (e) {

            e.preventDefault();

            loadDoctors(1);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '.doctor-page-btn',
        function (e) {

            e.preventDefault();

            var page = $(this).data('page');

            loadDoctors(page);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Experience Slider
    |--------------------------------------------------------------------------
    */

    $('#experience-range').on(
        'input',
        function () {

            $('#experience-value').text(
                $(this).val()
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Reset Filter
    |--------------------------------------------------------------------------
    */

    $('#reset-doctor-filter').on(
        'click',
        function (e) {

            e.preventDefault();


            /*
            | Reset Specialty
            */

            $('.doctor-specialization')
                .prop('checked', false);


            /*
            | Reset Appointment
            */

            $('#appointment')
                .prop('checked', false);


            /*
            | Reset Gender
            */

            $('input[name="gender"]')
                .prop('checked', false);

            $('input[name="gender"][value="no_preference"]')
                .prop('checked', true);


            /*
            | Reset Experience
            */

            $('#experience-range')
                .val(5);

            $('#experience-value')
                .text(5);


            /*
            | Load Default Doctors
            */

            loadDoctors(1);

        }
    );

});