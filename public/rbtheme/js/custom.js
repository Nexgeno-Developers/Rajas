(function($) {
    "use strict"
    // var telephone = $(".intlTelInput").intlTelInput({
    //     formatOnDisplay: false,
    //     separateDialCode: true,
    //     hiddenInput: "phone"
    // });
    // telephone.on("countrychange", function () {
    //     var code = $(".intlTelInput").intlTelInput("getNumber");
    //     $("input[name='phone']").val(code);
    //     var countryData = $("#phone").intlTelInput("getSelectedCountryData");
    //     var countryCode = countryData.dialCode; // using updated doc, code has been replaced with dialCode
    //     countryCode = "+" + countryCode;
    // });

    // $(".contactInput").intlTelInput({
    //     formatOnDisplay: false,
    //     separateDialCode: true,
    //     hiddenInput: "contact_phone"
    // }).on("countrychange", function () {
    //     var code = $(".intlTelInput").intlTelInput("getNumber");
    //     if(code.length > 0)
    //         $("input[name='contact_phone']").val(code);
    //         var countryData = $("#contact_phone").intlTelInput("getSelectedCountryData");
    //         var countryCode = countryData.dialCode; // using updated doc, code has been replaced with dialCode
    //         countryCode = "+" + countryCode;

    // });

    // $(".mobile").intlTelInput({
    //     formatOnDisplay: false,
    //     separateDialCode: true,
    //     hiddenInput: "mobile"
    // }).on("countrychange", function () {
    //     var code = $(".intlTelInput").intlTelInput("getNumber");
    //     if(code.length > 0)
    //         $("input[name='mobile']").val(code);
    //         var countryData = $("#mobile").intlTelInput("getSelectedCountryData");
    //         var countryCode = countryData.dialCode; // using updated doc, code has been replaced with dialCode
    //         countryCode = "+" + countryCode;
    // });

    let category_text = $(".custom-category").data('custom-category');
    let service_text = $(".custom-service").data('custom-service');
    let employee_text = $(".custom-employee").data('custom-employee');
    if ($('.btn-logout-click').length) {
        $(document).on('click','.btn-logout-click', function() {
            $('#logout-form').submit();
        })
    }
    $("#mark").on('click', function () {
        $.ajax({
        type: "POST",
        url: "{{ route('customer-notification') }}",
        data: { _token: '{{csrf_token()}}'},
        dataType: 'json',
        success: function(response) {
        $("#response").html(response.data);
          $(".notification-indicator").removeClass("notification-indicator");
          toastr.info(response.data);  
        }
        });
    });

    jQuery.validator.addMethod("letterOnly", function(value, element){
        return this.optional(element) || /^[a-zA-Z][a-zA-Z0-9\s]*$/gi.test(value);
    }, translate.please_enter_character_with_optional_digits);

    jQuery.validator.addMethod('regex', function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/gi.test(value);
    }, translate.please_enter_valid_email);

    $("#contact-form").validate({
        rules: {
            contact_name: {
                "required": true,
                letterOnly: true
            },
            contact_email: {
                required: true,
                email: true,
                regex: true,
            },
            contact_phone: {
                required: true,
                // minlength: 10,
                // maxlength: 13,
            },
            customer_message: "required",
        },
        messages: {
            contact_name: {
                required: translate.please_enter_name,
                letterOnly: translate.please_enter_character_with_optional_digits
            },
            contact_email: {
                required: translate.please_enter_the_email,
                email: translate.please_enter_valid_email,
                regex: translate.please_enter_valid_email
            },
            contact_phone: {
                required: translate.please_enter_phone_number,
                // minlength: translate.please_enter_minimum_10_digits,
                // maxlength: translate.please_maximum_10_digits
            },
            customer_message: {
                required: translate.please_enter_the_message
            },
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'contact_phone') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }

    });

    $("#newsletter-form").validate({
        rules: {
            newsletter_email: {
                required: true,
                email: true,
                regex: true
            }
        },
        messages: {
            newsletter_email: {
                required: translate.please_enter_the_email,
                email: translate.please_enter_valid_email,
                regex: translate.please_enter_valid_email
            }
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
    $("#bootstrap-wizard-category").on('change',function () {
        var category = $('option:selected', this).data('id');
        $("#time").val('');
            $.ajax({
                url: route('getService'),
                type: "POST",
                data: {
                    _token: _token,
                    category: category,
                },
                dataType: 'json',
            }).done(function (response) {
                var html = '<option value="">'+translate.select+' '+service_text+'</option>';
               
                if (response.length > 0) {
                    // $.each(response, function (key, value) {
                    //     html += '<option value="' + value.name + '" data-id="'+value.id+'" data-price="'+ value.price +'">' + value.name +
                    //         '</option>';
                    // });
                    $.each(response, function (key, value) {
                        html += '<option value="' + value.name + '" ' +
                                'data-id="' + value.id + '" ' +
                                'data-price="' + value.price + '" ' +
                                'data-tax="' + value.tax + '" ' +
                                'data-price-excluded-tax="' + value.price_excluded_tax + '" ' +
                                'data-allowed-weight="' + value.allowed_weight + '" ' +
                                'data-allowed-person="' + value.no_of_person_allowed + '">' + 
                                value.name + 
                                '</option>';
                    });                    
                    $("#bootstrap-wizard-service").html(html);
                }else {
                    $("#bootstrap-wizard-service").html(html);
                    $("#bootstrap-wizard-employee").html('<option value="">'+translate.select+' '+employee_text+'</option>');
                }
            });
    });


    $("#bootstrap-wizard-service").on('change',function () {
        var service = $('option:selected', this).data('id');
        $("#time").val('');
            if ($(".input-field").length == 1){
                var employee_id = $("#bootstrap-wizard-employee").val();
            }else {
                if(service) {
                    $.ajax({
                        url: route('getEmployee'),
                        type: "POST",
                        data: {
                            _token: _token,
                            service: service,
                        },
                        dataType: 'json',
                    }).done(function (response) {
                        if (response.length > 0) {
                            var selected = '';
                            var html = '';
                            $.each(response, function (key, value) {
                                if(key == 0) {
                                    selected ='selected';
                                } else {
                                    selected = '';
                                }
                                html += '<option value="' + value.id + '" '+selected+' >' + value.name +
                                    '</option>';
                            });
                        }
                        $("#bootstrap-wizard-employee").html(html);
                        var employee_id = $("#bootstrap-wizard-employee option:selected").val();
                        var selectedDate = $("#bootstrap-wizard-date").val();
                        var selectDate = wizard.querySelector('[data-wizard-validate-date]');
                        if(employee_id != '' && selectedDate != '') {
                            $.ajax({
                                url:  route('getAnotheremployee'),
                                type: "POST",
                                data: {
                                    _token: _token,
                                    employee_id: employee_id,
                                    selectedDate: selectedDate,
                                },
                                dataType: "json",
                            }).done(function (response) {
                                $("#employee_msg").html('');
                                var currentDate = new Date(selectDate.value);
                                var weekDays = response.workingDay;
                                if(!weekDays.includes(currentDate.getDay().toString())) {   
                                $("#employee_msg").html(translate.employee_not_available);
                                }
                            });
                        }
                    });
                } else {
                    $("#bootstrap-wizard-employee").html('<option value="">'+translate.select+' '+employee_text+'</option>');
                }  
            }
    });

    if ($(".input-field").length == 0){
        $("#bootstrap-wizard-employee").on('change',function () {
            var employee_id = $("#bootstrap-wizard-employee option:selected").val();
            var selectedDate = $("#bootstrap-wizard-date").val();
            var selectDate = wizard.querySelector('[data-wizard-validate-date]');
            if(employee_id != '' && selectedDate != '') {
                $.ajax({
                    url:  route('getAnotheremployee'),
                    type: "POST",
                    data: {
                        _token: _token,
                        employee_id: employee_id,
                        selectedDate: selectedDate,
                    },
                    dataType: "json",
                }).done(function (response) {
                    $("#employee_msg").html('');
                    var currentDate = new Date(selectDate.value);
                    var weekDays = response.workingDay;
                    if(!weekDays.includes(currentDate.getDay().toString())) {   
                    $("#employee_msg").html(translate.employee_not_available);
                    }
                });
            }
            $("#time").val('');
        });
    }
    
    
    $(document).off("click", ".bookly-hour").on("click", ".bookly-hour", function () {
        var category_id = $("#bootstrap-wizard-category option:selected").val();
        var service_id = $("#bootstrap-wizard-service option:selected").val();
        if ($(".input-field").length == 1){
            var employee_id = $("#bootstrap-wizard-employee").val();
        }else {
            var employee_id = $("#bootstrap-wizard-employee option:selected").val();
        }
        var selectedDate = $("#bootstrap-wizard-date").val();
        var value = $(this).data('value');
        if(!$(this).hasClass("not-allowed")){
            var check = true;
            $.ajax({
              type:"GET",
              url: route('getAppointment'),
              data: {
                _token: _token,
                employee_id: employee_id,
                selectDate: selectedDate,
                service_id: service_id,
                category_id: category_id,
                slot:value
              },
              success: function(response){
                if(response) { 
                    $(".payment-button").modal('show');
                    $("#msg").html('<p class="msg" style="color:red;">'+ response.data + '</p>');
                    $(".next-button").prop( "disabled", true );
                     check = false;
                }else{
                    $("#msg").html('');
                    $(".next-button").prop( "disabled", false );
                }
               
              }
            });
            if(check) {
                $('.bookly-hour-active').removeClass('bookly-hour-active');
                $(this).addClass('bookly-hour-active');
                $("#time").val(value);
                check = true;
                $(".next-button").prop( "disabled", false );
            }

        }else{
            $("#msg").html('<p class="booked_msg" style="color:red;">'+translate.slot_already_booked+'</p>');
        }
    });

    $("#bootstrap-wizard-date").on('change', function () {
        if($(".input-field").length == 1){
            var employee_id = $("#bootstrap-wizard-employee").val();
        }else{
            var employee_id = $("#bootstrap-wizard-employee option:selected").val();
        }
        var selectedDate = $("#bootstrap-wizard-date").val();
        var selectDate = wizard.querySelector('[data-wizard-validate-date]');
        if(employee_id != '' && selectedDate != '') {
            $.ajax({
                url:  route('getAnotheremployee'),
                type: "POST",
                data: {
                    _token: _token,
                    employee_id: employee_id,
                    selectedDate: selectedDate,
                },
                dataType: "json",
            }).done(function (response) {
                $("#employee_msg").html('');
                var currentDate = new Date(selectDate.value);
                var weekDays = response.workingDay;
                if(!weekDays.includes(currentDate.getDay().toString())) {   
                  $("#employee_msg").html(translate.employee_not_available);
                }
                    
            });
        }
        $("#time").val('');
    });

    $("#bootstrap-wizard-stripe").on('click', function () {
        var category = $("#bootstrap-wizard-category option:selected").text();
        var service = $("#bootstrap-wizard-service option:selected").text();
        var employee = $("#bootstrap-wizard-employee option:selected").text();
        var Date = $("#bootstrap-wizard-date").val();
        var price = $("#bootstrap-wizard-service option:selected").data('price');
        var firstName = $("#bootstrap-wizard-first-name").val();
        var lastName = $("#bootstrap-wizard-last-name").val();
        var customer = firstName+' '+lastName;
        let clientSecret;
        $.ajax({
            url: route('intent'),
            type: "POST",
            data: {
                _token: _token,
                category:category,
                service:service,
                employee:employee,
                date:Date,
                price:price, 
                customer:customer,
            },
            success: function(response){
                $("#getCode").html(response);
                $('#card-button').attr('data-secret',response);
                clientSecret = response;
            }   
         })
    });

    
    $(".payment_method").on('click', function(){
        $(".payment-container").removeClass('payment-shadow');
        var value = $(this).data('value');
        $("#payment_method").val(value);
        $(this).parent().parent().addClass("payment-shadow");
        $("#stripe-msg").html('');
    });

    $(".notification-indicator-primary").on("mouseenter", function() {
        $(".dropdown-menu").addClass('show');
    });
    $(".notification-indicator-primary").on("mouseleave", function() {
        $(".dropdown-menu").removeClass('show');
    });

    // Customer Profile
    $("#profile-detail-form").validate({
        rules: {
          first_name: {
            "required": true,
            letterOnly: true
          },
          last_name: {
            "required": true,
            letterOnly: true
          },
          email: {
            required: true,
            email: true,
            regex: true,
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
            regex: translate.please_enter_valid_email
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
    $("#changePassword-form").validate({
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
            equalTo: "#new-passworda"
          }
        },
        messages: {
          old_password: {
            required: translate.please_enter_current_password,
            min: translate.password_at_least_8_characters,
          },
          new_password: {
            required: translate.please_enter_new_password,
            min: translate.password_at_least_8_characters,
          },
          confirm_password: {
            required: translate.please_enter_password,
            min: translate.password_at_least_8_characters,
            equalTo: translate.confirm_password_does_not_match
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

    $('#profile-image').on('change', function(){
        let filename = $(this).val();
        let extension = filename.split('.').pop();
        if(extension != 'jpg' && extension != 'jpeg' && extension != 'png') {
            let error_messges = translate.user_image_valid_file_type;
            toastr.error(error_messges);
            return false;
        }
        let bytes = $(this)[0].files[0].size;
        let bytess = formatBytes(bytes);
        if(bytess.b > 8 && bytess.k != 'KiB') {
            let error_messges = translate.user_image_valid_size;
            toastr.error(error_messges);
            return false;
        } else {

            // Wait for grecaptcha token and THEN submit
            grecaptcha.ready(function () {
                grecaptcha.execute(RECAPTCHA_SITE_KEY, {action: 'submit'}).then(function (token) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'recaptcha_token';
                    input.value = token;
                    document.getElementById('profile-form').appendChild(input);

                    // Submit the form after token is added
                    document.getElementById('profile-form').submit();
                });
            });
        }
    })

    // Customer Appointment
    $('.back-btn-click').on('click', function() {
        window.location.href = route('dashboard');
    });
    $("#cancel").validate({
        rules: {
            cancel_reason:"required"
        },
        messages: {
            cancel_reason: translate.appointment_cancel_reason
        }
    });

   
}(jQuery));