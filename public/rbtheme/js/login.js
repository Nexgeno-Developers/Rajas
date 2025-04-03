(function($) {
    "use strict";

    jQuery.validator.addMethod("letterOnly", function(value, element){
        return this.optional(element) || /^[a-zA-Z][a-zA-Z0-9\s]*$/gi.test(value);
    }, translate.please_enter_character_with_optional_digits);
    jQuery.validator.addMethod('regex', function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/gi.test(value);
    }, translate.please_enter_valid_email);
    var loginValidator = $("#login").validate({
        rules: {
            email: {
            required: true,
            email: true,
            regex: true
            },
            password: {
            required: true,
            minlength: 8,
            }
        },
        messages: {
            email: {
            required: translate.please_enter_the_email,
            email: translate.please_enter_valid_email,
            },
            password: {
            required: translate.please_enter_password,
            minlength: translate.password_at_least_8_characters
            }
        }
    });
    
    var signValidator = $("#sign-up-form").validate({
        rules: {
            first_name: {
                "required": true,
                letterOnly: true,
            },
            last_name: {
                "required": true,
                letterOnly: true,
            },
            email: {
                required: true,
                email: true,
                regex: true
            },
            mobile: {
                required: true,
                // digits: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }
        },
        messages: {
            first_name: {
                required: translate.please_enter_first_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            last_name: {
                required: translate.please_enter_last_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            email: {
            required: translate.please_enter_the_email,
            email: translate.please_enter_valid_email,
            regex: true
            },
            mobile: {
            required: translate.please_enter_phone_number,
            // digits: translate.please_enter_only_digits_numeric
            },
            password: {
            required: translate.please_enter_password,
            min: translate.password_at_least_8_characters,
            },
            password_confirmation: {
            required: translate.please_enter_confirm_password,
            min: translate.password_at_least_8_characters,
            equalTo: translate.password_does_not_match
            }
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'mobile') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#loginModel").on('hidden.bs.modal', function() {
      loginValidator.resetForm();
    });
    $("#loginModel").on('shown.bs.modal', function() {
        $("#registerModel").modal('hide');
    });
    $("#registerModel").on('shown.bs.modal', function() {
        $("#loginModel").modal('hide');
    });
    $("#registerModel").on('hidden.bs.modal', function() {
      signValidator.resetForm();
    });
    
    // $(".default-credential").on("click", function() {
    //     let value = $(this).val();
    //     let email = $("input[name='email']");
    //     let password = $("input[name='password']");

    //     if($(".default-credential").is(':checked')) {
    //         if(value == 'admin') {
    //             email.val('admin@gmail.com');
    //             password.val('12345678');
    //         } else if (value == 'employee') {
    //             if($(".default-credential").is(':checked')) {
    //                 email.val('employee@gmail.com');
    //                 password.val('12345678');
    //             } else {
    //                 email.val('');
    //                 password.val('');
    //             }
    //         } else if(value == 'customer') {
    //             if($(".default-credential").is(':checked')) {
    //                 email.val('customer@gmail.com');
    //                 password.val('12345678');
    //             } else {
    //                 email.val('');
    //                 password.val('');
    //             }
    //         } else {
    //             email.val('');
    //             password.val('');
    //         }
    //     } else {
    //         email.val('');
    //         password.val('');
    //     }

    //     $.each($(".default-credential"), function(row, col) {
    //         if(col.value != value) {
    //             $(this).prop('checked', false);
    //         }
    //     });
    // });

    $("#forgot-password-form").validate({
        rules: {
            email: {
                required: true,
                email: true,
                regex: true
            },
        },
        messages: {
        email: {
            required: translate.please_enter_the_email,
            email: translate.please_enter_valid_email,
        }
        }
    });

    $("#reset-password-form").validate({
        rules: {
            email: {
                required: true,
                email: true,
                regex: true
            },
            password:{
                required: true,
                minlength: 8,
            },
            password_confirmation:{
                required: true,
                minlength: 8,
                equalTo: "#new-passwords"
            }
        },
        messages: {
        email: {
            required: translate.please_enter_the_email,
            email: translate.please_enter_valid_email,
        },
        password:{
            required: translate.please_enter_password,
            min: translate.password_at_least_8_characters,
        },
        password_confirmation:{
            required: translate.please_enter_confirm_password,
            min: translate.password_at_least_8_characters,
            equalTo: translate.password_does_not_match
        }
        }
    });
    
}(jQuery));