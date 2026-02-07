/* ============================================
   Nexora - Forms Page JavaScript
   ============================================ */

$(document).ready(function () {

    // ---- Select2 Initialization ----
    $('.select2-single').select2({
        theme: 'bootstrap-5',
        placeholder: 'Choose an option...',
        allowClear: true
    });

    $('.select2-multiple').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select skills...',
        closeOnSelect: false
    });

    // ---- jQuery UI Datepicker ----
    $('.datepicker').datepicker({
        dateFormat: 'mm/dd/yy',
        changeMonth: true,
        changeYear: true,
        showAnim: 'fadeIn'
    });

    // ---- jQuery Validation ----
    $('#basicForm').validate({
        rules: {
            fullname: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                equalTo: '[name="password"]'
            },
            terms: {
                required: true
            }
        },
        messages: {
            fullname: {
                required: 'Please enter your full name',
                minlength: 'Name must be at least 3 characters'
            },
            email: {
                required: 'Please enter your email',
                email: 'Please enter a valid email'
            },
            password: {
                required: 'Please enter a password',
                minlength: 'Password must be at least 6 characters'
            },
            confirm_password: {
                required: 'Please confirm your password',
                equalTo: 'Passwords do not match'
            },
            terms: 'You must agree to the terms'
        },
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.next('label'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function (form) {
            if (typeof toastr !== 'undefined') {
                toastr.success('Form submitted successfully!', 'Success');
            }
            return false;
        }
    });

    // ---- Dropzone Configuration ----
    Dropzone.autoDiscover = false;
    if ($('#fileDropzone').length) {
        var myDropzone = new Dropzone('#fileDropzone', {
            url: '/upload',
            maxFilesize: 5,
            maxFiles: 5,
            acceptedFiles: '.jpg,.jpeg,.png,.gif,.pdf',
            addRemoveLinks: true,
            dictRemoveFile: '<i class="fas fa-trash-alt"></i>',
            dictDefaultMessage: '',
            init: function () {
                this.on('addedfile', function () {
                    if (typeof toastr !== 'undefined') {
                        toastr.info('File added to upload queue', 'Upload');
                    }
                });
            }
        });
    }

    // ---- Form Wizard ----
    var currentStep = 1;
    var totalSteps = 3;

    function showStep(step) {
        $('.wizard-panel').hide();
        $('#step' + step).show();
        $('.wizard-step').removeClass('active completed');
        for (var i = 1; i <= totalSteps; i++) {
            var $wizStep = $('.wizard-step[data-step="' + i + '"]');
            if (i < step) {
                $wizStep.addClass('completed');
            } else if (i === step) {
                $wizStep.addClass('active');
            }
        }
        $('#wizardPrev').prop('disabled', step === 1);
        if (step === totalSteps) {
            $('#wizardNext').html('<i class="fas fa-check me-1"></i> Submit');
        } else {
            $('#wizardNext').html('Next <i class="fas fa-arrow-right ms-1"></i>');
        }
    }

    $('#wizardNext').on('click', function () {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.success('Wizard completed successfully!', 'Done');
            }
        }
    });

    $('#wizardPrev').on('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

});
