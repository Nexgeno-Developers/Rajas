(function($) {
    "use strict";
    // var telephone = $(".intlTelInput").intlTelInput({
    //     formatOnDisplay: false,
    //     separateDialCode: true,
    //     hiddenInput: "phone"
    // });
    // telephone.on("countrychange", function () {
    //     var code = $(".intlTelInput").intlTelInput("getNumber");
    //     var countryData = $("#phone").intlTelInput("getSelectedCountryData");
    //     var countryCode = countryData.dialCode; // using updated doc, code has been replaced with dialCode
    //     countryCode = "+" + countryCode;
    // });

    // var telephone = $(".intlTelInput").intlTelInput({
    //     formatOnDisplay: false,
    //     separateDialCode: true,
    //     hiddenInput: "phone"
    // });
    // telephone.on("countrychange", function () {
    //     var code = $(".intlTelInput").intlTelInput("getNumber");
    //     // $("input[name='phone']").val(code);
    // });
    
    // $(".twilioLivePhone").intlTelInput({
    //     formatOnDisplay: false,
    //     separateDialCode: true,
    //     hiddenInput: "twilio_phone"
    // }).on("countrychange", function() {
    //     var code = $(".twilioLivePhone").intlTelInput("getNumber");
    //     $("input[name='twilio_phone']").val(code);
    // });
    $(".next-show-button").on("click", function() {
        $('.current-page').hide();
        $('.next-page').show();
    });

    $(".back-show-button").on("click", function() {
        $('.next-page').hide();
        $('.current-page').show();
    });
    jQuery.validator.addMethod("letterOnly", function(value, element){
        return this.optional(element) || /^[a-zA-Z][a-zA-Z0-9\s"?,\-_|\/\.\(\)]*$/gi.test(value);
    }, translate.please_enter_character_with_optional_digits);

    jQuery.validator.addMethod('regex', function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/gi.test(value);
    }, translate.please_enter_valid_email);

    if($('.data-table').length > 0) {
        let dataTable = document.querySelector('.data-table');
        let elementCount = dataTable.querySelector("thead tr").childElementCount;
        let dtConfig = {};
        let bSort, bSearch;
        switch (dataTable.getAttribute('id')) {
            case 'cat-table':
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": [2]},
                        { "bSearchable": false, "targets": [2]}
                    ]
                };    
                break;
            case 'service-table':
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": [4, 7, 8]},
                        { "bSearchable": false, "targets": [4,7,8]}
                    ]
                };
                break;
            case 'emp-table':
                if(elementCount == 10)
                    bSort = bSearch = [6,7,8,9];
                else
                    bSort = bSearch = [5,6,7,8];
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": bSort},
                        { "bSearchable": false, "targets": bSearch}
                    ]
                };
                break;
            case 'customer-table':
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": [5, 6]},
                        { "bSearchable": false, "targets": [5, 6]}
                    ]
                };
                break;
            case 'appointment-table':
                bSort = [8,9,10]
                bSearch = [10]
                if(elementCount == 10) {
                    bSort = [7,8,9];
                    bSearch = [9];
                } else {
                    bSort = [8,9,10];
                    bSearch = [10];
                }
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": bSort},
                        { "bSearchable": false, "targets": bSearch}
                    ]
                };
                break;
            case 'customer-appointment-table':
                bSort = bSearch = [6,7,8,9];
                if(elementCount == 9) {
                    bSort = bSearch = [5,6,7,8];
                }
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": bSort},
                        { "bSearchable": false, "targets": bSearch}
                    ]
                };
                break;
            case 'payment-table':
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": [4, 5, 6, 7]},
                        { "bSearchable": false, "targets": [4, 5, 6, 7]}
                    ]
                };
                break;
            case 'employee-payment-table':
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": [4, 5, 6]},
                        { "bSearchable": false, "targets": [4, 5, 6]}
                    ]
                };
                break;
            case 'notification-table':
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": [2]},
                        { "bSearchable": false, "targets": [2]}
                    ]
                };
                break;
            default:
                dtConfig = {
                    "columnDefs": [
                        { "bSortable":false, "targets": '_all'}
                    ]
                };
                break;
        }
        $('.data-table').DataTable(dtConfig);
        $('.data-table').on('draw.dt', function () {
            $('input:checkbox').bootstrapToggle();
        });
    }
    $('.status').bootstrapToggle({
        height:35,
        width:70,
    });
    $('#smtp_mail').bootstrapToggle({
        height:35,
        width:70,
    });
    $('.toggle-set').bootstrapToggle({
        height:35,
        width:70,
    });
    $('form input[type=text]').on('keyup', function(){
        $(this).siblings(".error-message").hide();
    });
    $('form input[type=tel]').on('keyup', function(){
        $(this).siblings(".error-message").hide();
    });
    $('form input[type=email]').on('keyup', function(){
        $(this).siblings(".error-message").hide();
    });
    $("select[name='category_id']").on('change',function(){
        $(this).siblings(".error-message").hide();
    });
    $('form textarea').on('keyup', function(){
        $(this).siblings(".error-message").hide();
    });
    $('form input[type=password]').on('keyup', function(){
        $(this).siblings(".error-message").hide();
    });
    $('form input[type="time"]').on('change', function(){
        $(this).siblings(".error-message").hide();
    });

    $("#category-form").validate({
        rules: {
            name: {
                "required": true,
                letterOnly: true
            }
        },
        messages: {
            name: {
                required: translate.please_enter_category_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            }
        }
    });
    const CUSTOM_DATE_FORMAT = $(".custom-format").data('date-format');
    if(CUSTOM_DATE_FORMAT != undefined) {
        const config = {
        };
        $("#date").flatpickr(config);
        const config1 = {
            altInput: true,
            altFormat: CUSTOM_DATE_FORMAT,
            dateFormat: 'Y-m-d',
            disableMobile: "true"
        };
        $(".date").flatpickr(config1);
        $(".flicker").flatpickr(config1);
        const config2 = {
            altInput: true,
            altFormat: CUSTOM_DATE_FORMAT,
            dateFormat: 'Y-m-d',
            minDate: 'today',
            maxDate: new Date().fp_incr(60)
        };
        $("#adate").flatpickr(config2);
    }
    $("#customerDetail").validate({
        rules: {
            first_name: {required: true, letterOnly: true},
            last_name: {required: true, letterOnly: true},
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
                // minlength: 10,
                // maxlength: 13,
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
          },
          phone: {
            required: translate.please_enter_phone_number,
            // minlength: translate.please_enter_minimum_10_digits,
            // maxlength: translate.please_maximum_10_digits
          }
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'phone') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#duration").on("change", function() {
        if($(this).val() == "") {
            $(this).parent().removeClass("d-none", "400");
            $(".duration_24hr_div").removeClass("d-none", "400");
        } else {
            $(".duration_24hr_div").addClass("d-none", "400");
        }
    });

    $("#service_duration").on("change", function() {
        $(".service_duration_custom_error").remove();
        if($(this).is(':checked') == false) {
            $(".duration_24hr_div").removeClass("d-none", "400");
            $(".duration_hr_div").removeClass("d-none", "400");
        } else {
            $(".duration_hr_div").addClass("d-none", "400");
            $("#duration").val('');
            $(".duration_24hr_div").removeClass("d-none", "400");
        }
    });
    jQuery.validator.addMethod("priceOnly", function(value, element) {
        return this.optional(element) || /^[0-9\.]*$/g.test(value);
    }, translate.please_enter_only_digits_numeric);

    $("#serviceDetail").validate({
        rules: {
            name: {
                required: true,
                letterOnly: false
            },
            description: {
                required:true,
                letterOnly: false
            },
            price: {required: true, priceOnly: true},
            duration: {
                required: function(element) {
                    return $("#service_duration:checked").val()=="";
                }
            },
            duration_24hr: {
                required: function(element) {
                    return $("#duration").val()=="";
                }
            },
            cancel_before: {required: true},
            image: {
                required: function(element) {
                    return $("#service_image").data('value')=="";
                }
            }
        },
        messages: {
            name: { 
                required: translate.please_enter_service_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            description: {
                required: translate.please_enter_description,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            price: {
                required: translate.please_enter_service_price,
                priceOnly: translate.please_enter_only_digits_numeric
            },
            duration: translate.please_enter_service_duration,
            duration_24hr: translate.please_enter_service_duration,
            cancel_before: translate.please_enter_cancel_appointment_time,
            image: translate.please_select_service_image
        },
        errorPlacement: function(error, element) {
            $(".service_duration_custom_error, .cancel-appointment_error").remove();
            if(element[0].name == 'duration' || element[0].name == 'cancel_before' || element[0].name == 'duration_24hr' || element[0].name == "price") {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            let duration = $("#duration").val();
            let serviceDuration = $("#service_duration").is(':checked');
            if(duration == '00:00' && serviceDuration === false) {
                $(".service_duration_custom_error").remove();
                $("#duration").focus();
                $("#duration").parent().after("<label class='error service_duration_custom_error'>"+translate.please_enter_service_duration+"</label>")
                return false;
            }
            $(".cancel-appointment_error").remove();
            let cancel_before = $("#cancel-before");
            if(cancel_before.val() == '00:00') {
                cancel_before.parent().after("<label class='error cancel-appointment_error'>"+translate.please_enter_cancel_appointment_time+"</label>");
                return false;
            }
            $(".service_imgage_error").remove();
            let service_image = $("#service_image");
            if(service_image == undefined || service_image[0] == undefined || (service_image.data('value') == "" && service_image[0].files[0] == undefined)) return false;
            if(service_image[0].files.length) {
                let filename = service_image.val();
                let extension = filename.split('.').pop();
                if(extension.toLowerCase() != 'jpg' && extension.toLowerCase() != 'jpeg' && extension.toLowerCase() != 'png') {
                    let error_messges = translate.service_image_valid_file_type;
                    $("#service_image").after("<label class='error service_imgage_error'>"+error_messges+"</label>");
                    return false;
                }
                let bytes = service_image[0].files[0].size;
                let bytess = formatBytes(bytes);
                if(bytess.b > 8 && bytess.k != "KiB") {
                    let error_messges = translate.service_image_valid_size;
                    $("#service_image").after("<label class='error service_imgage_error'>"+error_messges+"</label>");
                    return false;
                } else {
                    form.submit();
                }
            } else {
                form.submit();
            }
        }
    });

    function formatBytes(bytes, decimals = 2)
    {
        if(!bytes) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        let return_val = { b:`${parseFloat((bytes / Math.pow(k, i))).toFixed(dm)}`, k: `${sizes[i]}`};
        return return_val;
    }

    $("#employee-frm").validate({
        rules: {
            first_name: {"required": true, letterOnly: true},
            last_name: {"required": true, letterOnly: true},
            email: {"required": true, "email": true},
            password: {"required": true, minlength: 8, maxlength: 12},
            phone: {"required": true},
            start_time: "required",
            finish_time:"required",
            rest_time: "required",
            // break_start_time:"required",
            // break_end_time: "required",
            "days[]": "required",
            "category_id[]": "required",
            service_id: "required"
        },
        messages: {
            service_id: {
                required: translate.please_select_service
            },
            first_name: {
                "required": translate.please_enter_first_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            last_name: {
                "required":translate.please_enter_last_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            email: {
                required: translate.please_enter_the_email,
                email: translate.please_enter_valid_email
            },
            password: {
                "required": translate.please_enter_password,
            },
            phone: {
                "required": translate.please_enter_phone_number,
            },
            start_time: {
                "required": translate.please_enter_start_time
            },
            finish_time:{
                "required": translate.please_enter_end_time
            },
            rest_time: {
                "required": translate.please_enter_rest_time
            },
            /*break_start_time:{
                "required": translate.please_enter_break_start_time
            },
            break_end_time: {
                "required": translate.please_enter_break_end_time
            },*/
            "days[]": {
                "required": translate.please_select_working_days
            },
            "category_id[]": {
                "required": translate.please_select_categories
            },
            // "service_id[]": {
            //     "required": translate.please_select_services
            // },
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'phone' || element[0].name == 'rest_time' || element[0].name == 'start_time' || element[0].name == 'finish_time' || element[0].name == 'break_start_time' || element[0].name == 'break_end_time') {
                error.appendTo(element.parent().parent());
            } else if(element[0].name == 'days[]' || element[0].name == 'category_id[]' || element[0].name == 'service_id') {
                error.appendTo(element.parent().parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#employeeForm").validate({
        rules: {
            first_name: {
                "required": true,
                letterOnly: true
            },
            last_name: {
                "required": true,
                letterOnly: true
            },
            email: {"required": true, "email": true},
            password: {"required": true, minlength: 8, maxlength: 12},
            phone: {"required": true, digits: true},
            start_time: "required",
            finish_time:"required",
            rest_time: "required",
            // break_start_time:"required",
            // break_end_time: "required",
        },
        messages: {
            service_id: {
                required: translate.please_select_service
            },
            first_name: {
                "required": translate.please_enter_first_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            last_name: {
                "required":translate.please_enter_last_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            email: {
                required: translate.please_enter_the_email,
                email: translate.please_enter_valid_email
            },
            password: {
                "required": translate.please_enter_password,
            },
            phone: {
                "required": translate.please_enter_phone_number,
                digits: translate.please_enter_only_digits_numeric
            },
            start_time: {
                "required": translate.please_select_start_time
            },
            finish_time:{
                "required": translate.please_select_end_time
            },
            rest_time: {
                "required": translate.please_enter_rest_time
            },
            /*break_start_time:{
                "required": translate.please_select_break_start_time
            },
            break_end_time: {
                "required": translate.please_select_break_end_time
            },*/
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'phone' || element[0].name == 'rest_time' || element[0].name == 'start_time' || element[0].name == 'finish_time' || element[0].name == 'break_start_time' || element[0].name == 'break_end_time') {
                let error_element = element.parent().parent();
                if(error_element != undefined) { let span = error_element[0].querySelector("span.error"); if(span != undefined) span.remove(); }
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    }); 
    $('#reset').on('click', function(){
        $('#service_id').prop('selectedIndex',0);
        $('#employee_id').prop('selectedIndex',0);
        $('#customer').prop('selectedIndex',0);
        $('#startdate').val("");
        $('#enddate').val("");
        $('#status').prop('selectedIndex',0);
        $('#payment_method').prop('selectedIndex',0);
        $('#filter-form').submit(); 
    });

    $("#formdata").validate({
        rules: {
            category_id: {
                required: true
            },
            service_id: {
                required: true
            },
            employee_id: {
                required: true
            },
            user_id: {
                required: true
            },
            date: {
                required: true
            },
            comments: {
                required: true
            }
        },
        messages: {
            category_id: {
                required: translate.please_select_category
            },
            service_id: {
                required: translate.please_select_service
            },
            employee_id: {
                required: translate.please_select_employee
            },
            user_id: {
                required: translate.please_select_customer
            },
            date: {
                required: translate.please_select_appointment_date
            },
            comments: {
                required: translate.please_enter_comment_appointment
            }
        }
    });

    $("#account-info").validate({
        rules: {
          account_no: "required",
          cheque_no: "required",
          account_holder_name: "required",
          bank_name: "required",
          ifsc_code:"required",
          payment_date:"required",
          amount:{
                  required: true,
                  priceOnly: true,
              },
        },
        messages: {
            account_no: translate.please_enter_account_number,
            cheque_no: translate.please_enter_cheque,
            account_holder_name: translate.please_enter_holder_name,
            bank_name: translate.please_enter_bank_name,
            ifsc_code:translate.please_enter_ifsc_code,
            payment_date:translate.please_enter_payment_date,
            amount:{
                required: translate.please_enter_ifsc_code,
                priceOnly: translate.please_enter_only_digits_numeric,
            },
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'amount') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $("#upi-frm").validate({
          rules: {
              upi_id: "required",
              payment_date:"required",
              amount:{
                  required: true,
                  priceOnly: true,
              }
          },
          messages: {
              upi_id: translate.please_enter_upi_id,
              payment_date:translate.please_enter_payment_date,
              amount:{
                  required: translate.please_enter_amount,
                  priceOnly: translate.please_enter_only_digits_numeric,
              }
          },
          errorPlacement: function(error, element) {
              if(element[0].name == 'amount') {
                  error.appendTo(element.parent().parent());
              } else {
                  error.insertAfter(element);
              }
          }
    });
    $("#cash-frm").validate({
          rules: {
              payment_date:"required",
              amount:{
                  required: true,
                  priceOnly: true,
              }
          },
          messages: {
              payment_date: translate.please_enter_payment_date,
              amount:{
                  required: translate.please_enter_amount,
                  priceOnly: translate.please_enter_only_digits_numeric,
              }
          },
          errorPlacement: function(error, element) {
              if(element[0].name == 'amount') {
                  error.appendTo(element.parent().parent());
              } else {
                  error.insertAfter(element);
              }
          }
    });

    $("#site-frm").validate({
        rules: {
          site_title: {
            "required": true,
            letterOnly: true
          },
          about_company: {
            "required": true,
            letterOnly: true
          },
          address: {
            "required": true,
            letterOnly: true
          },
          email: {
              required: true,
              email: true,
          },
          phone: {
              required: true,
            //   maxlength: 13,
            //   minlength: 10,
          },
          facebook:"required",
          twitter: "required",
          linkedin: "required",
          instagram: "required",
        },
        messages: {
          site_title: {
            "required":translate.please_enter_site_title,
            letterOnly: translate.please_enter_character_with_optional_digits
          },
          about_company: {
            "required": translate.please_enter_about_company,
            letterOnly: translate.please_enter_character_with_optional_digits
          },
          address: {
            "required": translate.please_enter_address,
            letterOnly: translate.please_enter_character_with_optional_digits
          },
          email:  {
              required: translate.please_enter_the_email,
              email: translate.please_enter_valid_email,
          },
          phone: {
              required: translate.please_enter_phone_number,
            //   maxlength: translate.please_maximum_10_digits,
            //   minlength: translate.please_enter_minimum_10_digits,
          },
          facebook:translate.please_enter_facebook,
          twitter: translate.please_enter_twitter,
          linkedin: translate.please_enter_linkedin,
          instagram: translate.please_enter_instagram,
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'phone') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $("#smtp-frm").validate({
        rules: {
          smtp_email: {
              required: true,
              email: true,
          },
          smtp_password: "required",
          smtp_host: "required",
          smtp_port: "required",
        },
        messages: {
          smtp_email:  {
              required: translate.please_enter_smtp_email,
              email: translate.please_enter_valid_email,
          },
          smtp_password: translate.please_enter_smtp_password,
          smtp_host: translate.please_enter_smpt_host,
          smtp_port: translate.please_enter_smpt_port,
        }
    });
    $("#sms-frm").validate({
        rules: {
            twilio_account_sid: {
                required: function ( element ) {
                    return $("#sms-notification").is(':checked');
                }
            },
            twilio_auth_token: {
                required: function ( element ) {
                    return $("#sms-notification").is(':checked');
                }
            },
            twilio_country_code: {
                required: function ( element ) {
                    return $("#sms-notification").is(':checked');
                }
            },
            twilio_phone_number: {
                required: function ( element ) {
                    return $("#sms-notification").is(':checked');
                },
                // digits: true,
                // minlength: 10,
                // maxlength: 10,
            }
        },
        messages: {
            twilio_account_sid: "Please enter Twilio Account Sid",
            twilio_auth_token: "Please enter Twilio Auth Token",
            twilio_country_code: "Please enter country code",
            twilio_phone_number: {
                required: "Please enter twilio phone numbers",
                // digits: "Twlio phone number must be digits or numeric",
                // minlength: "Twilio phone number minimum 10 numbers",
                // maximum: "Twilio phone number maximum 10 numbers"
            }
        }
    });
    $("#custom-frm").validate({
        rules: {
          custom_field_text: {
            "required": true,
            letterOnly: true
          },
          custom_field_category: {
            "required": true,
            letterOnly: true
          },
          custom_field_service: {
            "required": true,
            letterOnly: true
          }
        },
        messages: {
            custom_field_text: {
                "required":translate.please_enter_employee,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            custom_field_category: {
                "required":translate.please_enter_category,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            custom_field_service: {
                "required":translate.please_enter_service,
                letterOnly: translate.please_enter_character_with_optional_digits
            }
        }
    });
    $("#currency-frm").validate({
        rules: {
          currency: "required",
          currency_icon: "required",
          },
        messages: {
          currency: translate.please_enter_currency,
          currency_icon: translate.please_enter_currency_icon,
        }
    });

    $("#timezone-frm").validate({
        rules: { timezone: "required"},
        messages: { timezone: translate.please_enter_time_zone}
    });
    $("#account").validate({
        rules: {
          first_name: {
              required: true,
              letterOnly: true
          },
          last_name: {
              required: true,
              letterOnly: true
          },
          email: {
            required: true,
            email: true,
            regex: true
          },
          phone: {
            required: true,
            // minlength: 10,
            // maxlength: 13,
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
            regex: translate.please_enter_valid_email,
          },
          phone: {
            required: translate.please_enter_phone_number,
            // minlength: translate.please_enter_minimum_10_digits,
            // maxlength: translate.please_maximum_10_digits
          }
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'phone') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#change-password").validate({
        rules: {
          old_password: {
            required: true,
            minlength: 8,
          },
          new_password: {
            required: true,
            minlength: 8,
          },
          confirm_password: {
            required: true,
            minlength: 8,
            equalTo: "#new-password"
          }
        },
        messages: {
          old_password: {
            required: translate.please_enter_current_password,
            min: translate.please_enter_8_characters,
          },
          new_password: {
            required: translate.please_enter_new_password,
            min: translate.please_enter_8_characters,
          },
          confirm_password: {
            required: translate.please_enter_confirm_password,
            min: translate.please_enter_8_characters,
            equalTo: translate.password_does_not_match
          }
        }
    });

    $("#social").validate({
          rules: {
              facebook: {
                  required: true,
                  url: true
              },
              instagram: {
                  required: true,
                  url: true
              },
              twitter: {
                  required: true,
                  url: true
              },
              linkedin: {
                  required: true,
                  url: true
              }
          },
          messages: {
              facebook: {
                  required: translate.please_enter_facebook_link,
                  url: translate.please_enter_valid_facebook_link
              },
              instagram: {
                  required: translate.please_enter_instagram_link,
                  url: translate.please_enter_valid_instagram_link
              },
              twitter: {
                  required: translate.please_enter_twitter_link,
                  url: translate.please_enter_valid_twitter_link
              },
              linkedin: {
                  required: translate.please_enter_linkedin_link,
                  url: translate.please_enter_valid_linkedin_link
              }
          }
    });

    $('.account-settings-fileinput').on('change', function() {
        $(".user_image_error").remove();
        let filename = $(this).val();
        let extension = filename.split('.').pop();
        if(extension != 'jpg' && extension != 'jpeg' && extension != 'png') {
            let error_messges = translate.user_image_valid_file_type;
            $(".user_profile_after").after("<p class='error user_image_error'>"+error_messges+"</p>");
            return false;
        }
        let bytes = $(this)[0].files[0].size;
        let bytess = formatBytes(bytes);
        if(bytess.b > 8 && bytess.k != 'KiB') {
            let error_messges = translate.user_image_valid_size;
            $(".user_profile_after").after("<p class='error user_image_error'>"+error_messges+"</p>");
            return false;
        } else {
            $('#profile-form').submit();
        }
    });

    $(document).on("click",".toggle-password",function() {
        if($(this).hasClass('open')) {
            $(this).next().removeClass('d-none');
            $(this).addClass('d-none');
        } else {
          $(this).prev().removeClass('d-none');
          $(this).addClass('d-none');
        }
        var input = $('#'+$(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(".stripeSubmit").on('click', function() {
        $(".error").remove();
        var flag = true;
        var stripeKey = $("input[name='stripe_key']").val();
        var stripeSecret = $("input[name='stripe_secret']").val();
        var stripeLiveKey = $("input[name='stripe_live_key']").val();
        var stripeLiveSecret = $("input[name='stripe_secret_live']").val();
        if(stripeKey.match("^pk_test_") == null) {
            $("input[name='stripe_key']").after('<span class="error">'+translate.please_enter_valid_key+'</span>');
            flag = false;
        }
        if(stripeSecret.match("^sk_test_") == null) {
            $("input[name='stripe_secret']").after('<span class="error">'+translate.please_enter_valid_secret+'</span>');
            flag = false;
        }

        if(stripeLiveKey.match("^pk_live_") == null) {
            $("input[name='stripe_live_key']").after('<span class="error">'+translate.please_enter_valid_live_key+'</span>');
            flag = false;
        }

        if(stripeLiveSecret.match("^sk_live_") == null) {
            $("input[name='stripe_secret_live']").after('<span class="error">'+translate.please_enter_valid_live_secret+'</span>');
            flag = false;
        }

        if(flag) {
            $("#StripeForm").submit();
        }
    });

    $(".paypalSubmit").on('click', function() {
        $(".error").remove();
        var flag = true;
        var paypalKey = $("input[name='paypal_client_id']").val();
        var paypalSecret = $("input[name='paypal_client_secret']").val();
        var paypalLocale = $("input[name='paypal_locale']").val();
        var paypalLiveKey = $("input[name='paypal_live_client_id']").val();
        var paypalLiveSecret = $("input[name='paypal_client_secret_live']").val();

        if(paypalKey == '') {
            $("input[name='paypal_client_id']").after('<span class="error">'+translate.please_enter_paypal_key+'</span>');
            flag = false;
        }
        if(paypalSecret == '') {
            $("input[name='paypal_client_secret']").after('<span class="error">'+translate.please_enter_paypal_secret+'</span>');
            flag = false;
        }
        if(paypalLocale == '') {
            $("input[name='paypal_locale']").after('<span class="error">'+translate.please_enter_paypal_locale+'</span>');
            flag = false;
        }
        if(paypalLiveKey == '') {
            $("input[name='paypal_live_client_id']").after('<span class="error">'+translate.please_enter_paypal_live_key+'</span>');
            flag = false;
        }
        if(paypalLiveSecret == '') {
            $("input[name='paypal_client_secret_live']").after('<span class="error">'+translate.please_enter_paypal_live_secret+'</span>');
            flag = false;
        }
        if(flag) {
            $("#paypalForm").submit();
        }
    });

    $(".razorPaySubmit").on("click", function() {
        $(".error").remove();
        var flag = true;
        var razorpayKey = $("input[name='razorpay_test_key']").val();
        var razorpaySecret = $("input[name='razorpay_test_secret']").val();
        var razorpayLive = $("input[name='razorpay_live_key']").val();
        var razorpayLiveSecret = $("input[name='razorpay_live_secret']").val();

        if(razorpayKey.match("^rzp_test_") == null) {
            $("input[name='razorpay_test_key']").after('<span class="error">'+translate.please_enter_valid_key+'</span>');
            flag = false;
        }
        if(razorpaySecret == '') {
            $("input[name='razorpay_test_secret']").after('<span class="error">'+translate.please_enter_valid_secret+'</span>');
            flag = false;
        }
        if(razorpayLive.match("^rzp_live_") == null) {
            $("input[name='razorpay_live_key']").after('<span class="error">'+translate.please_enter_valid_live_key+'</span>');
            flag = false;
        }
        if(razorpayLiveSecret == '') {
            $("input[name='razorpay_live_secret']").after('<span class="error">'+translate.please_enter_valid_live_secret+'</span>');
            flag = false;
        }

        if(flag) {
            $("#razorpayForm").submit();
        }
    });
    var inp = document.querySelector('#Ilogo');
    if(inp) {
        inp.addEventListener('change', function(e) {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                document.getElementById('logoimage').src = this.result;
            };
            reader.readAsDataURL(file);
        }, false);
    }
    
    var inp = document.querySelector('#favicon');
    if(inp) {
        inp.addEventListener('change', function(e) {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                document.getElementById('faviconimage').src = this.result;
            };
            reader.readAsDataURL(file);
        }, false);
    
    }
    $('.btn-print-click').on('click', function() {
        window.print();
    });

    $("#notification-frm").validate({
        onclick: function() {
            $("#notification-error").empty();
            return true;
        },
        errorClass:"text-danger",
        errorElement: "div",
        rules: {
            twilio_notify_customer: {
                required: {
                    depends: function(element) {
                        return (!$("input[name='twilio_notify_employee']").is(':checked') && !$("input[name='twilio_notify_admin']").is(':checked'));
                    }
                }
            },
            twilio_notify_employee: {
                required: {
                    depends: function (element) {
                        return (!$("input[name='twilio_notify_customer']").is(':checked') && !$("input[name='twilio_notify_admin']").is(':checked'));
                    }
                }
            },
            twilio_notify_admin: {
                required: {
                    depends: function (element) {
                        return (!$("input[name='twilio_notify_customer']").is(':checked') && !$("input[name='twilio_notify_employee']").is(':checked'));
                    }
                }
            },
            twilio_sandbox_key: {
                required: true
            },
            twilio_sandbox_secret: {
                required: true
            },
            twilio_service_id: {
                required: {
                    depends: function (element) {
                        return ($("input[name='use_twilio_service_id']").is(':checked'));
                    }
                }
            },
            twilio_live_key: {
                required: true
            },
            twilio_live_secret: {
                required: true
            },
            twilio_phone: {
                required: true,
                // digits: true
            }
        },
        messages: {
            twilio_notify_customer: {
                required: translate.please_select_any_one_notification
            },
            twilio_notify_employee: {
                required: translate.please_select_any_one_notification
            },
            twilio_notify_admin: {
                required: translate.please_select_any_one_notification
            },
            twilio_sandbox_key: {
                required: translate.please_enter_twilio_sandbox_key
            },
            twilio_sandbox_secret: {
                required: translate.please_enter_twilio_sandbox_secret
            },
            twilio_phone: {
                required: translate.please_enter_twilio_phone,
                // digits: translate.twilio_phone_number_digit_numeric
            },
            twilio_live_key: {
                required: translate.please_enter_twilio_live_key
            },
            twilio_live_secret: {
                required: translate.please_enter_twilio_live_secret
            },
            twilio_service_id: {
                required: translate.please_enter_twilio_messaging_service_id
            }
        },
        errorPlacement: function (error, element) {
            if(element[0].name == "twilio_phone") {
                error.appendTo(element.parent().parent());
            } else if(element[0].name == "twilio_notify_customer" || element[0].name == "twilio_notify_employee" || element[0].name == "twilio_notify_admin") {
                $("#notification-error").empty(); 
                error.appendTo($("#notification-error"));
            } else {
                error.insertAfter(element);
            }
        }
    });
    let checkEmailValidator = $("#checkEmail").validate({
        rules: {
            to: {
                required: true,
                email: true
            }
        },
        messages: {
            to: {
                required: translate.please_enter_the_email,
                email: translate.please_enter_valid_email
            }
        }
    });
    $("#testMailModel").on('hidden.bs.modal', function() {
        checkEmailValidator.resetForm();
        $(".alert").remove();
    });

    $(document).on("click", ".verifySmtp", function() {
        $('.loader').show();
        if($("#checkEmail").valid() == true) {
            $(".alert").remove();
            $.ajax({
                url: route('verifyMail'),
                type: "POST",
                data: $("#checkEmail").serialize(),
                dataType: "json",
                success: function (resp) {
                    $('.loader').hide();
                    if(resp.status) {
                        let html = '<div class="alert alert-success" role="alert"><h4 class="alert-heading">'+translate.success+'</h4><p>';
                        html += resp.messages;
                        html += '<p><hr><p>'+translate.email_success_config_correct;
                        html += '</p></div>';
                        $(".modal-body").prepend(html);
                    } else {
                        let html = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">'+translate.oops_error+'</h4><p>';
                        html += resp.messages;
                        html += '<p><hr><p>'+translate.email_config_not_correct;
                        html += '</p></div>';
                        $(".modal-body").prepend(html);
                    }
                }, error: function(error) {
                    let html = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">'+translate.oops_error+'</h4><p>';
                    html += translate.someting_goes_wrong;
                    html += '<p><hr><p>'+translate.email_config_not_correct;
                    html += '</p></div>';
                    $(".modal-body").prepend(html);
                    $('.loader').hide();        
                }
            });
        } else {
            $('.loader').hide();
        }
    });

    $("#location").on("change paste", function () {
        let maplocation = $(this).val();
        setTimeout(() => {
            $(".map").html(maplocation);
            $(".location").removeClass('d-none');
        }, 500);
    });
    var format = $(".date-format").data('value');
    $(".date-format option").each(function(key,val) {
        if(val.value == format) {
            $(this).attr('selected',true);
        }
    });

    // start test mail 
    let checkSmsValidator = $("#checkSms").validate({
        rules: {
            phone: {
                required: true,
            }
        },
        messages: {
            phone: {
                required: translate.please_enter_phone_number,
            }
        },
        errorPlacement: function (error, element) {
            if(element[0].name == "phone") {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $("#testSmsModel").on('hidden.bs.modal', function() {
        checkSmsValidator.resetForm();
        $(".alert").remove();
    });
    $(document).on("click", ".verifySms", function() {
        $('.loader').show();
        if($("#checkSms").valid() == true) {
            $(".alert").remove();
            $.ajax({
                url: route('verifySms'),
                type: "POST",
                data: $("#checkSms").serialize(),
                dataType: "json",
                success: function (resp) {
                    $('.loader').hide();
                    console.log(resp);
                    if(resp.status) {
                        let html = '<div class="alert alert-success" role="alert"><h4 class="alert-heading">'+translate.success+'</h4><p>';
                        html += resp.messages;
                        html += '<p><hr><p>'+translate.sms_success_config_correct;
                        html += '</p></div>';
                        $(".modal-body").prepend(html);
                    } else {
                        let html = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">'+translate.oops_error+'</h4><p>';
                        html += resp.messages;
                        html += '<p><hr><p>'+translate.sms_config_not_correct;
                        html += '</p></div>';
                        $(".modal-body").prepend(html);
                    }
                }, error: function(error) {
                    let html = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">'+translate.oops_error+'</h4><p>';
                    html += translate.someting_goes_wrong;
                    html += '<p><hr><p>'+translate.sms_config_not_correct;
                    html += '</p></div>';
                    $(".modal-body").prepend(html);
                    $('.loader').hide();        
                }
            });
        } else {
            $('.loader').hide();
        }
    });
    // end test mail 

    $(document).off("click", ".open-service-image").on("click", ".open-service-image", function(e) {
        let img = e.currentTarget; //.querySelector("img");
        let srcImg = (img != undefined && img.getAttribute("data-original") != undefined) ? img.getAttribute("data-original") : undefined;
        if(srcImg != undefined) {
            $("#serviceImagePopup").attr('src', srcImg);
            $("#serviceImageModal").modal('toggle');
        }
    });

    tinymce.init({
        selector: 'textarea.tinymce-editor', // class or ID
        plugins: 'lists link code table',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
        height: 300,
    });   
    
    tinymce.init({
        selector: 'textarea.tinymce-readonly', // class or ID
        plugins: 'lists link code table',
        toolbar: false,
        menubar: false,
        readonly: true,
        height: 500,
    });     
})(jQuery);