/* -------------------------------------------------------------------------- */
/*                                 Timer - CountDown                          */
/* -------------------------------------------------------------------------- */
'use strict';
var time = parseInt(localStorage.time);
var minutes = 1 * 60;
var seconds;
var stopTimer = false;
function countdown() {
  //var minutes = 1 * 60;
  var minutes = 15 * 60;
  time = parseInt(localStorage.time);
  if (isNaN(time) || time > (minutes)) {
    localStorage.time = minutes;
    countdown();
    return null;
  }

  if (time <= 0) {
    stopTimer = true;
    $("#stripemodal").modal('hide');
    toastr.error(translate.appointment_time_out);
    var appointment_id = document.getElementById("appointment_id").value;
    $.ajax({
      url: route('maximum.time.expire'),
      type: "POST",
      data: { appointment_id: appointment_id, _token: _token },
      dataType: "json",
    }).done(function (response) {
      setTimeout(() => {
        location.reload();
      }, 1000);
    });
  }

  $('.timeleft').html(formatTime(time));
  time--;
  localStorage.time = time;
  if (!stopTimer)
    setTimeout('countdown()', 1000);
}

function formatTime(time) {
  minutes = Math.floor(time / 60);
  seconds = time - minutes * 60;

  if (String(seconds).length == 1) {
    return String(minutes) + ":0" + String(seconds);

  }
  return String(minutes) + ":" + String(seconds);
}
localStorage.time = '';

(function($){
"use strict";

/* -------------------------------------------------------------------------- */

/*                                    Utils                                   */

/* -------------------------------------------------------------------------- */
var docReady = function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        setTimeout(fn, 1);
    }
};

var resize = function resize(fn) {
    return window.addEventListener('resize', fn);
};

var isIterableArray = function isIterableArray(array) {
    return Array.isArray(array) && !!array.length;
};

var camelize = function camelize(str) {
    var text = str.replace(/[-_\s.]+(.)?/g, function (_, c) {
        return c ? c.toUpperCase() : '';
    });
    return "".concat(text.substr(0, 1).toLowerCase()).concat(text.substr(1));
};

var getData = function getData(el, data) {
    try {
        return JSON.parse(el.dataset[camelize(data)]);
    } catch (e) {
        return el.dataset[camelize(data)];
    }
};

var utils = {
    docReady: docReady,
    resize: resize,
    isIterableArray: isIterableArray,
    camelize: camelize,
    getData: getData
};


/* -------------------------------------------------------------------------- */

/*                                 step wizard                                */

/* -------------------------------------------------------------------------- */


var wizardInit = function wizardInit() {
    var wizards = document.querySelectorAll('.theme-wizard');
    var tabPillEl = document.querySelectorAll('#pill-tab2 [data-bs-toggle="pill"]');
    var tabProgressBar = document.querySelector('.theme-wizard .progress');
    wizards.forEach(function (wizard) {
        var tabToggleButtonEl = wizard.querySelectorAll('[data-wizard-step]');
        var selectCategory = wizard.querySelector('[data-wizard-validate-category]');
        var selectService = wizard.querySelector('[data-wizard-validate-service]');
        var selectEmployee = wizard.querySelector('[data-wizard-validate-employee]');
        var selectDate = wizard.querySelector('[data-wizard-validate-date]');
        var selectSlot = wizard.querySelector('[data-wizard-validate-slot]');
        var inputFirstName = wizard.querySelector('[data-wizard-validate-first-name]');
        var inputLastName = wizard.querySelector('[data-wizard-validate-last-name]');
        var inputPhone = wizard.querySelector('[data-wizard-validate-phone]');
        var country = wizard.querySelector('[data-wizard-validate-country]'); //new
        var state = wizard.querySelector('[data-wizard-validate-state]'); //new
        var allowedPerson = wizard.querySelector('[data-wizard-validate-allowed-person]'); //new
        var allowedWeight = wizard.querySelector('[data-wizard-validate-allowed-weight]'); //new
        var govermentId = wizard.querySelector('[data-wizard-validate-goverment-id]'); //new
        var inputDetail = wizard.querySelector('[data-wizard-validate-detail]');
        var inputEmail = wizard.querySelector('[data-wizard-validate-email]');
        var inputpayment = wizard.querySelector('[data-wizard-validate-payment]');
        var emailPattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var phonePattern = /^([0-9])+$/;//inputPhone.getAttribute('pattern');
        var form = wizard.querySelector('[novalidate]');
        var nextButton = wizard.querySelector('.next button');
        var prevButton = wizard.querySelector('.previous button');
        var cardFooter = wizard.querySelector('.theme-wizard .card-footer');
        var letterPattern = /^([a-zA-z\s])+$/;
        var count = 0;
        var validatePattern = function validatePattern(pattern, value) {
            // var regexPattern = new RegExp(pattern);
            // return regexPattern.test(String(value).toLowerCase());
            return value;
        };
        var validatePhone = function validatePhone(e) {
            var validkeys = ['+','0','1','2','3','4','5','6','7','8','9'];
            if(validkeys.indexOf(e.key) < 0) {
                return true;
            }
            return false;
        }
        prevButton.classList.add('d-none'); // on button click tab change

        inputPhone.addEventListener('keyup', function(e) {
            if(inputPhone.value && validatePhone(e)) {
                
                form.classList.add('was-validated');
                // document.querySelector(".phone-error").innerHTML = translate.phone_should_be_digits;
                // document.querySelector(".phone-error").style.display = 'block';
                if(e.which > 64 && e.which < 91) {
                    e.preventDefault();
                    return false;
                }
            }
            // if(inputPhone.value && inputPhone.value.length < 10) {
            //     e.preventDefault();
            //     form.classList.add('was-validated');
            //     document.querySelector(".phone-error").innerHTML = translate.please_enter_minimum_10_digits;
            //     document.querySelector(".phone-error").style.display = 'block';
            //     return false;
            // }
            // if(inputPhone.value) {
            //     e.preventDefault();
            //     form.classList.add('was-validated');
            //     document.querySelector(".phone-error").style.display = 'block';
            //     return false;
            // }
            form.classList.remove('was-validated');
            document.querySelector(".phone-error").style.display = '';
            document.querySelector(".phone-error").innerHTML = translate.please_enter_phone_number;
        });
        
        inputFirstName.addEventListener('keyup', function(e) {
            if(this.value && validatePattern(letterPattern, this.value)) {
                this.nextElementSibling.style.display = '';
            }
        });

        inputLastName.addEventListener('keyup', function(e) {
            if(this.value && validatePattern(letterPattern, this.value)) {
                this.nextElementSibling.style.display = '';
            }
        });
        nextButton.addEventListener('click', function () {
            if (count == 0) {
                if (!selectService.options[selectService.options.selectedIndex].value || 
                   ((selectEmployee.nodeName == 'INPUT') ? !selectEmployee.value  :
                        !selectEmployee.options[selectEmployee.options.selectedIndex].value)
                    || !selectDate.value) {
                    selectDate.removeAttribute('readonly');
                    form.classList.add('was-validated');
                } else if ($("#employee_msg").text() != '') {
                    return null;
                } else {
                    if (custom == 1) {
                        if (selectCategory.options[selectCategory.options.selectedIndex].value != '') {
                            $(".category_name").html(selectCategory.options[selectCategory.options.selectedIndex].text);
                        } else {
                            selectDate.removeAttribute('readonly');
                            form.classList.add('was-validated');
                            return null;
                        }
                    }
                    $(".service_name").html(selectService.options[selectService.options.selectedIndex].text);
                    if(selectEmployee.nodeName == 'INPUT') {
                        $(".employee_name").data('employee');
                    }else{
                        $(".employee_name").html(selectEmployee.options[selectEmployee.options.selectedIndex].text);
                    }
                    $(".booking_date").html(moment(selectDate.value).format('MMMM DD, YYYY'));
                    $(".booking_price").html(selectService.options[selectService.options.selectedIndex].getAttribute('data-price'));

                    //new 
                    // $(".other_information").html(`
                    //     <p class="mt-0 mb-0"><strong>Number of Person:</strong> ${allowedPerson.value}</p>
                    //     <p class="mt-0 mb-0"><strong>Total Weight:</strong> ${allowedWeight.value} Kg</p>
                    // `);
                    // alert(2);

                    $('#bootstrap-wizard-allowed-person').attr('max', selectService.options[selectService.options.selectedIndex].getAttribute('data-allowed-person'));
                    $('#bootstrap-wizard-allowed-weight').attr('max', selectService.options[selectService.options.selectedIndex].getAttribute('data-allowed-weight'));
                    allowedPerson.nextElementSibling.innerHTML = "Maximum number of persons allowed is " + allowedPerson.getAttribute('max');
                    allowedWeight.nextElementSibling.innerHTML = "Maximum weight allowed is " + allowedWeight.getAttribute('max') + " kg";                    
                    //new

                    count += 1;
                    var tab = new window.bootstrap.Tab(tabToggleButtonEl[count]);
                    tab.show();
                }
            } else if (count == 1) {
                if (!selectSlot.value) {
                    form.classList.add('was-validated');
                    if (document.querySelector("#msg").innerHTML == '') {
                        document.querySelector("#msg").innerHTML = translate.please_select_appointment_slot;
                        document.querySelector("#msg").style.color = 'red';
                        document.querySelector("#msg").scrollIntoView({ behavior: 'smooth', block: 'center' }); // New
                    }
                } else {
                    count += 1;
                    var tab = new window.bootstrap.Tab(tabToggleButtonEl[count]);
                    form.classList.remove('was-validated');
                    tab.show();
                    $(".booking_time").html(selectSlot.value);
                }
            } else if (count == 2) {
                inputPhone.value = inputPhone.value.replace("+","");
                // console.log("Goverment ID in Count :" + govermentId.value);
                // console.log("Country in Count :" + country.value);
                // console.log("State in Count :" + state.value);
                // console.log("allowedPerson in Count :" + allowedPerson.value);
                // console.log("allowedWeight in Count :" + allowedWeight.value);
                if ((!inputEmail.value || !inputFirstName.value || !inputLastName.value || !inputPhone.value || !inputDetail.value || !govermentId.value || !country.value || !state.value || !allowedPerson.value || !allowedWeight.value)) {
                    if (!inputEmail.value) {
                        document.querySelector(".email-error").innerHTML = translate.please_enter_the_email;
                    }
                    if(!inputPhone.value) {
                        document.querySelector(".phone-error").style.display = 'block';
                    }
                    form.classList.add('was-validated');
                    inputFirstName.nextElementSibling.innerHTML = translate.please_enter_first_name;
                    inputLastName.nextElementSibling.innerHTML = translate.please_enter_last_name;
                } else if(inputFirstName.value && !validatePattern(/^([a-zA-z])+$/, inputFirstName.value)) {
                    inputFirstName.nextElementSibling.innerHTML = translate.please_enter_only_characters;
                    inputFirstName.nextElementSibling.style.display = 'block';
                } else if(inputLastName.value && !validatePattern(/^([a-zA-z])+$/, inputLastName.value)) {
                    inputLastName.nextElementSibling.innerHTML = translate.please_enter_only_characters;
                    inputLastName.nextElementSibling.style.display = 'block';
                } else if (inputEmail.value && !validatePattern(emailPattern, inputEmail.value)) {
                    // form.classList.add('was-validated');
                    document.querySelector(".email-error").innerHTML = translate.please_enter_valid_email;
                    document.querySelector(".email-error").style.display = 'block';
                }/* else if(inputPhone.value && (inputPhone.value.length < 10) ) { 
                    form.classList.add('was-validated');
                    document.querySelector(".phone-error").style.display = 'block';
                    document.querySelector(".phone-error").innerHTML = translate.please_enter_minimum_10_digits;
                }*/
                else if(inputPhone.value && !validatePattern(phonePattern, inputPhone.value)) { 
                    // form.classList.add('was-validated');
                    document.querySelector(".phone-error").style.display = 'block';
                    document.querySelector(".phone-error").innerHTML = translate.phone_should_be_digits;
                }  else if(parseFloat(allowedPerson.value) == 0 || (parseFloat(allowedPerson.value) > parseFloat(allowedPerson.getAttribute('max'))) ){
                    form.classList.add('was-validated');
                    allowedPerson.nextElementSibling.innerHTML = "Maximum number of persons allowed is " + allowedPerson.getAttribute('max');
                    //allowedPerson.nextElementSibling.style.display = 'block';
                }  else if(parseFloat(allowedWeight.value) == 0 || (parseFloat(allowedWeight.value) > parseFloat(allowedWeight.getAttribute('max'))) ){
                    form.classList.add('was-validated');
                    allowedWeight.nextElementSibling.innerHTML = "Maximum weight allowed is " + allowedWeight.getAttribute('max') + " kg";
                    //allowedWeight.nextElementSibling.style.display = 'block';
                }  else {
                    document.querySelector(".phone-error").style.display = '';
                    document.querySelector(".email-error").style.display = '';
                    inputFirstName.nextElementSibling.style.display = '';
                    inputFirstName.nextElementSibling.innerHTML = translate.please_enter_first_name;
                    inputLastName.nextElementSibling.style.display = '';
                    inputLastName.nextElementSibling.innerHTML = translate.please_enter_last_name;
                    if(inputEmail.value && !LOGGED) {
                        var flag = false;
                        $.ajax({
                            url: route('check.user.email'),
                            type: "POST",
                            async: true,
                            data: {
                                _token: _token,
                                email: inputEmail.value
                            },
                            dataType: "json",
                            success: function(response) {
                                if(response.success) {
                                    if(response.exits || response.phoneExist) {
                                        console.log(response);
                                        flag = true;
                                    } else {
                                        flag = false;
                                    }
                                    document.getElementById('email-check').innerHTML = response.msg;
                                    document.querySelector("#email-check").scrollIntoView({ behavior: 'smooth', block: 'center' }); // New
                                }
                                if(flag) {
                                    return null;
                                } else {
                                    document.getElementById('email-check').innerHTML = '';
                                    count += 1;
                                    var tab = new window.bootstrap.Tab(tabToggleButtonEl[count]);
                                    form.classList.remove('was-validated');
                                    tab.show();
                                }
                            }
                        });
                    } else {
                        document.getElementById('email-check').innerHTML = '';
                        count += 1;
                        var tab = new window.bootstrap.Tab(tabToggleButtonEl[count]);
                        form.classList.remove('was-validated');
                        tab.show();
                    }

                    $(".other_information").html(`
                        <p class="mt-0 mb-0"><strong>Number of Person:</strong> ${allowedPerson.value}</p>
                        <p class="mt-0 mb-0"><strong>Total Weight:</strong> ${allowedWeight.value} Kg</p>
                    `);
                    //alert(1);                    

                    //validation start - new
                    // form.classList.add('was-validated');
                    // const country = document.querySelector('[name="country"]').value;
                    // const state = document.querySelector('[name="state"]').value;
                    // const govermentId = document.querySelector('[name="goverment_id"]').value;

                    // if (!country) {
                    //     alert("country is required");
                    //     return null;
                    // }

                    // if (!state) {
                    //     alert("state is required");
                    //     return null;
                    // }     
                    
                    // if (!govermentId) {
                    //     alert("state is required");
                    //     return null;
                    // }                     
                    
                    // console.log("Country ID:", country);
                    // console.log("State ID:", state);
                    // console.log("Goverment ID:", govermentId);

                    // form.classList.remove('was-validated');
                    //validation end - new

                }
            } else if (count == 3) {
                form.classList.remove('was-validated');
                if (inputpayment.value) {
                    count += 1;
                    var tab = new window.bootstrap.Tab(tabToggleButtonEl[count]);
                    tab.show();
                    $(".next-button").html(translate.book_appointment);
                    if (inputpayment.value == 'stripe') {
                        $(".next-button").html(translate.book_appointment);
                        $(".spinner-border").show();
                    }
                    if (inputpayment.value == 'razorpay') {
                        $(".next-button").html(translate.book_appointment);
                    }
                    if (inputpayment.value == 'payumoney') { //new
                        //alert("payumoney");
                        $(".next-button").html(translate.book_appointment);
                    }                    
                } else {
                    document.querySelector("#stripe-msg").innerHTML = translate.please_select_payment_method;
                    document.querySelector("#stripe-msg").style.color = 'red';
                    form.classList.add('was-validated');
                }
            } else if (count == 4) {
                var configMSg = document.querySelector("#confirm-msg");
                var confirmDetail = document.querySelector("#confirm-detail");
                $('#preloader').delay(100).fadeOut('slow', function() {
                    $(this).show();
                });
                // var code = $(".intlTelInput").intlTelInput("getNumber");
                // $("input[name='phone']").val(code);
                $.ajax({
                    type: "POST",
                    url: route('appointment.create'),
                    data: $("#formdata").serialize(),
                    success: function (response) {
                        confirmDetail.classList.add('d-none');
                        $('#preloader').delay(100).fadeOut('slow', function() {
                            $(this).hide();
                        });
                        if(response.error) {
                            console.log('configMSg');
                            configMSg.innerHTML = response.error;
                            configMSg.style.color = '#e63757';
                        } else {
                            if (inputpayment.value == 'stripe') {
                                $("#stripemodal").modal('show');
                                $('.modal-backdrop').addClass('d-none');
                                $('body').css('overflow', 'auto');
                                countdown();
                                $(".countdown").removeClass('d-none');
                            }
                            $('#card-button').attr('data-appointment', response.appointment_id);
                            $("#appointment_id").val(response.appointment_id);
                            if (inputpayment.value == 'paypal') {
                                $(".next-button").hide();
                                countdown();
                                $(".countdown").removeClass('d-none');
                                $("#paypal-button-container").removeClass('d-none');
                                configMSg.innerHTML = translate.please_pay_create_appointment;
                                configMSg.style.color = '#00aaff';
                                $(".next-button").html(translate.book_another_appointment);
                            }
                            if (inputpayment.value == 'razorpay') {
                                countdown();
                                $(".countdown").removeClass('d-none');
                                nextButton.innerHTML = translate.book_another_appointment;
                                nextButton.style.display = 'none';
                                $(".pay-razorpay").trigger('click');
                            }
                            if (inputpayment.value == 'payumoney') { //new
                                //alert("payumoney payumoney");
                                countdown();
                                $(".countdown").removeClass('d-none');
                                nextButton.innerHTML = translate.book_another_appointment;
                                nextButton.style.display = 'none';
                                $(".pay-payumoney").trigger('click');
                            }                            
                            if (inputpayment.value == 'offline') {
                                configMSg.innerHTML = response.data;
                                configMSg.style.color = '#00d27a';
                                $(".next-button").html(translate.book_another_appointment);
                            }
                            count += 1;
                            tabToggleButtonEl.forEach(function (tab) {
                                tab.classList.add('disabled');
                            });
                        }
                    }, error: function(jqXHR, status, error) {
                        $('#preloader').delay(100).fadeOut('slow', function() {
                            $(this).hide();
                        });
                    }
                });
            } else if (count == 5) {
                window.location.reload();
            }
        });
        prevButton.addEventListener('click', function () {
            count -= 1;
            var tab = new window.bootstrap.Tab(tabToggleButtonEl[count]);
            tab.show();
        });
        if (tabToggleButtonEl.length) {
            tabToggleButtonEl.forEach(function (item, index) {
                /* eslint-disable */
                item.addEventListener('show.bs.tab', function (e) {
                    var step = e.target.dataset.winzardId - 1;
                    if (step == 0) {
                        if (!selectService.options[selectService.options.selectedIndex].value ||
                            ((selectEmployee.nodeName == 'INPUT') ? !selectEmployee.value  :
                             !selectEmployee.options[selectEmployee.options.selectedIndex].value)
                              || !selectDate.value) {
                            e.preventDefault();
                            selectDate.removeAttribute('readonly');
                            form.classList.add('was-validated');
                            return null;
                            /* eslint-enable */
                        } else if ($("#employee_msg").text() != '') {
                            e.preventDefault();
                            return null;
                        } else {
                            if (custom == 1) {
                                if (selectCategory.options[selectCategory.options.selectedIndex].value != '') {
                                    $(".category_name").html(selectCategory.options[selectCategory.options.selectedIndex].text);
                                } else {
                                    e.preventDefault();
                                    selectDate.removeAttribute('readonly');
                                    form.classList.add('was-validated');
                                    return null;
                                }
                            }
                            $(".service_name").html(selectService.options[selectService.options.selectedIndex].text);
                            if(selectEmployee.nodeName == 'INPUT') {
                                $(".employee_name").data('employee');
                            }else {
                                $(".employee_name").html(selectEmployee.options[selectEmployee.options.selectedIndex].text);
                            }
                            $(".booking_date").html(moment(selectDate.value).format('MMMM DD, YYYY'));
                            $(".booking_price").html(selectService.options[selectService.options.selectedIndex].getAttribute('data-price'));

                            //new 
                            // $(".other_information").html(`
                            //     <p class="mt-0 mb-0"><strong>Number of Person:</strong> ${allowedPerson.value}</p>
                            //     <p class="mt-0 mb-0"><strong>Total Weight:</strong> ${allowedWeight.value} Kg</p>
                            // `);
                            // alert(1);

                            $('#bootstrap-wizard-allowed-person').attr('max', selectService.options[selectService.options.selectedIndex].getAttribute('data-allowed-person'));
                            $('#bootstrap-wizard-allowed-weight').attr('max', selectService.options[selectService.options.selectedIndex].getAttribute('data-allowed-weight'));
                            allowedPerson.nextElementSibling.innerHTML = "Maximum number of persons allowed is " + allowedPerson.getAttribute('max');
                            allowedWeight.nextElementSibling.innerHTML = "Maximum weight allowed is " + allowedWeight.getAttribute('max') + " kg";                    
                            //new                          

                            var service_id = $("#bootstrap-wizard-service option:selected").data('id');
                            if(selectEmployee.nodeName == 'INPUT') {
                                var employee_id = selectEmployee.value;
                            }else {
                                var employee_id = $("#bootstrap-wizard-employee option:selected").val();
                            }
                            var selectedDate = $("#bootstrap-wizard-date").val();

                            if (selectedDate != "" && employee_id != "" && !selectSlot.value) {
                                $.ajax({
                                    url: route('getTimeSlot'),
                                    type: "POST",
                                    data: {
                                        _token: _token,
                                        employee_id: employee_id,
                                        selectedDate: selectedDate,
                                        service_id: service_id
                                    },
                                    dataType: "json",
                                }).done(function (response) {
                                    var currentDate = new Date(selectDate.value);
                                    var weekDays = response.workingDay;
                                    if (!weekDays.includes(currentDate.getDay().toString())) {
                                        $("#msg").html('<p class="booked_msg" style="color:red;">'+translate.date_not_available+'</p>');
                                        $("#time-slots").html('');
                                    } else {
                                        if (response.slots.length > 0) {
                                            var html = '';
                                            $("#msg").html('');
                                            $("#time-slots").html('');
                                            $.each(response.slots, function (key, value) {
                                                var hide_slots = '';
                                                var disabled = '';
                                                var weight = 'bold';
                                                if (response.book_time.length > 0) {
                                                    var slot_start_time =  new Date(selectedDate+' '+value.start_time);
                                                    var slot_end_time =  new Date(selectedDate+' '+value.end_time);
                                                    var s_start = slot_start_time.getTime();
                                                    var s_end = slot_end_time.getTime();
                                                    $.each(response.book_time, function (k, val) {
                                                        var start_time = moment(new Date(val.date + ' ' + val.start_time)).format('hh:mm A');
                                                        var end_time = moment(new Date(val.date + ' ' + val.finish_time)).format('hh:mm A');
                                                        // if (start_time <= value.start_time && end_time >= value.end_time) {
                                                        //     hide_slots = 'not-allowed';
                                                        //     disabled = 'disabled';
                                                        //     weight = 'normal';
                                                        // }
                                                        //start google booked slot
                                                        
                    
                                                        var google_start_time =  new Date(val.date+' '+start_time);
                                                        var google_end_time = new Date(val.date+' '+end_time);
                    
                                                        var g_start = google_start_time.getTime();
                                                        var g_end = google_end_time.getTime();
                    
                                                        
                                                        if(s_end == g_start) {
                                                        } else if(s_start <= g_start && g_start <= s_end) {
                                                            hide_slots = 'not-allowed';
                                                            disabled = 'disabled';
                                                        } else if(s_end >= g_start && s_end <= g_end) {
                                                            hide_slots = 'not-allowed';
                                                            disabled = 'disabled';
                                                        } else if(g_end > s_start && s_end > g_end) {
                                                            hide_slots = 'not-allowed';
                                                            disabled = 'disabled';
                                                        }
                                                        /*if(g_end == s_start){
                                                            hide_slots = ''; 
                                                           
                                                        }else if(s_end == g_start){
                                                            hide_slots = 'not-allowed';
                                                           
                                                        }else if(s_end >= g_start && g_end >= s_start ){
                    
                                                            hide_slots = 'not-allowed'; 
                    
                                                            disabled = 'disabled' ;
                                                        }*/

                                                        //end google booked slot
                                                    });

                                                }
                                                if (response.slots.length == 1) {
                                                    html += '<div class="col-md-12">';
                                                } else {
                                                    html += '<div class="col-md-6">';
                                                }
                                                html +=
                                                    '<button type="button" class="bookly-hour ' + hide_slots + '" data-value="' +
                                                    value.start_time + '-' + value.end_time + '" ' + disabled + '>';
                                                html +=
                                                    '<span class="ladda-label bookly-time-main bookly-' + weight + '">';
                                                html += '<i class="bookly-hour-icon"><span></span></i>';
                                                html += value.start_time + ' - ' + value.end_time +
                                                    '</span><span class="bookly-time-additional"></span></button></div>';
                                            });
                                            if (response.slots.length == response.book_time.length) {
                                                $("#msg").html('');
                                                $("#msg").append('<p class="booked_msg" style="color:red;">'+translate.selected_date_appointment_booked+'</p>');
                                                toastr.error(translate.selected_date_appointment_booked);
                                            }
                                            $("#time-slots").html(html);
                                        } else {
                                            $("#msg").html('');
                                            $("#msg").append('<p class="booked_msg" style="color:red;">'+translate.booking_not_available+'</p>');
                                            $("#time-slots").html('');
                                        }
                                    }
                                });
                            }
                        }
                    } else if (step == 1) {
                        form.classList.remove('was-validated');
                        if (!selectSlot.value) {
                            form.classList.add('was-validated');
                            if (document.querySelector("#msg").innerHTML == '') {
                                document.querySelector("#msg").innerHTML = translate.please_select_appointment_slot;
                                document.querySelector("#msg").style.color = 'red';
                            }
                            e.preventDefault();
                            if ($('#time-slots').length > 1) {
                                toastr.error(translate.please_select_appointment_slot);
                            }
                            selectDate.removeAttribute('readonly');
                            form.classList.add('was-validated');
                            return null;
                        }
                        $(".booking_time").html(selectSlot.value);
                    } else if (step == 2) {
                        form.classList.remove('was-validated');
                        // console.log("Goverment ID in Step :" + govermentId.value);
                        // console.log("Country in Step :" + country.value);
                        // console.log("State in Step :" + state.value);
                        // console.log("allowedPerson in Step :" + allowedPerson.value);
                        // console.log("allowedWeight in Step :" + allowedWeight.value);                        
                        if ((!(inputEmail.value && validatePattern(emailPattern, inputEmail.value)) || !inputFirstName.value || !inputLastName.value || !inputPhone.value || !inputDetail.value || !govermentId.value || !country.value || !state.value || !allowedPerson.value || !allowedWeight.value)) {
                            if (validatePattern(emailPattern, inputEmail.value)) {
                                document.querySelector(".email-error").innerHTML = translate.please_enter_valid_email;
                            }else if(!selectSlot.value){
                                form.classList.add('was-validated');
                                if (document.querySelector("#msg").innerHTML == '') {
                                    document.querySelector("#msg").innerHTML = translate.please_select_appointment_slot;
                                    document.querySelector("#msg").style.color = 'red';
                                }
                            } else {
                                document.querySelector(".email-error").innerHTML = translate.please_enter_the_email;
                            }
                            e.preventDefault();
                            selectDate.removeAttribute('readonly');
                            form.classList.add('was-validated');
                            return null;
                        } else if (inputEmail.value && !validatePattern(emailPattern, inputEmail.value)) {
                            form.classList.add('was-validated');
                            document.querySelector(".email-error").innerHTML = translate.please_enter_valid_email;
                            e.preventDefault();
                            return null;

                        } 
                        // else if(inputPhone.value && (inputPhone.value.length < 10) ) { 
                        //     form.classList.add('was-validated');
                        //     document.querySelector(".phone-error").style.display = 'block';
                        //     document.querySelector(".phone-error").innerHTML = translate.please_enter_minimum_10_digits;
                        //     e.preventDefault();
                        //     return null;
                        else if(inputPhone.value && !validatePattern(phonePattern, inputPhone.value)) { 
                            form.classList.add('was-validated');
                            document.querySelector(".phone-error").style.display = 'block';
                            // document.querySelector(".phone-error").innerHTML = translate.phone_should_be_digits;
                            e.preventDefault();
                            return null;
                        } else if(parseFloat(allowedPerson.value) == 0 || (parseFloat(allowedPerson.value) > parseFloat(allowedPerson.getAttribute('max'))) ){
                            //alert("max person allowed : " + allowedPerson.getAttribute('max'));
                            e.preventDefault();
                            return null;
                        } else if(parseFloat(allowedWeight.value) == 0 || (parseFloat(allowedWeight.value) > parseFloat(allowedWeight.getAttribute('max'))) ){
                            //alert("max person allowed : " + allowedWeight.getAttribute('max'));
                            e.preventDefault();
                            return null;
                        }  else if(inputEmail.value && !LOGGED) {
                            var flag = false;
                            $.ajax({
                                url: route('check.user.email'),
                                type: "POST",
                                async: false,
                                data: {
                                    _token: _token,
                                    email: inputEmail.value
                                },
                                dataType: "json",
                                success: function(response) {
                                    if(response.success) {
                                        if(response.exits) {
                                            flag = true;
                                        } else {
                                            flag = false;
                                        }
                                        document.getElementById('email-check').innerHTML = response.msg;
                                        document.querySelector("#email-check").scrollIntoView({ behavior: 'smooth', block: 'center' }); // New
                                    }
                                }
                            });
                            if(flag) {
                                e.preventDefault();
                                return null;
                            }
                        }


                        //validation start - new
                        // form.classList.add('was-validated');
                        // const country = document.querySelector('[name="country"]').value;
                        // const state = document.querySelector('[name="state"]').value;
                        // const govermentId = document.querySelector('[name="goverment_id"]').value;

                        // if (!country) {
                        //     form.classList.add('was-validated');
                        //     alert("country is required!");
                        //     return null;
                        // }

                        // if (!state) {
                        //     alert("state is required!");
                        //     return null;
                        // }     
                        
                        // if (!govermentId) {
                        //     alert("state is required!");
                        //     return null;
                        // }                     
                        
                        // console.log("Country ID:", country);
                        // console.log("State ID:", state);
                        // console.log("Goverment ID:", govermentId);

                        // form.classList.add('was-validated');
                        //form.classList.remove('was-validated');
                        //validation end - new

                        $('.payment_method[data-value="payumoney"]').trigger('click'); //new - default payu select

                    } else if (step == 3) {
                        form.classList.remove('was-validated');
                        if (!selectService.options[selectService.options.selectedIndex].value ||
                            ((selectEmployee.nodeName == 'INPUT') ? !selectEmployee.value  :
                             !selectEmployee.options[selectEmployee.options.selectedIndex].value)
                            || !selectDate.value) {
                            form.classList.add('was-validated');
                            selectDate.removeAttribute('readonly');
                            e.preventDefault();
                            return null;
                        } else if(!selectSlot.value) {
                            e.preventDefault();
                                 form.classList.add('was-validated');
                                if (document.querySelector("#msg").innerHTML == '') {
                                    document.querySelector("#msg").innerHTML = translate.please_select_appointment_slot;
                                    document.querySelector("#msg").style.color = 'red';
                                    return null;
                                }
                                return null;
                        }else if(!inputEmail.value || !inputFirstName.value || !inputLastName.value || !inputPhone.value || !inputDetail.value) {
                            e.preventDefault();
                            form.classList.add('was-validated');
                            document.querySelector(".email-error").innerHTML = translate.please_enter_the_email;
                            return null;
                        }else if (inputpayment.value == "") {
                            e.preventDefault();
                             form.classList.add('was-validated');
                            document.querySelector("#stripe-msg").style.color = 'red';
                            document.querySelector("#stripe-msg").innerHTML = translate.please_select_payment_method;
                            return null;
                        }
                        }
                         
                    

                    count = index; // can't go back tab
                    if (count === tabToggleButtonEl.length - 1) {
                    } //add done class
                    if (count === tabToggleButtonEl.length - 1) {
                        if (count == 4) {
                            $(".user_email").html($('#email').val());
                            tabToggleButtonEl.forEach(function (tab) {
                                nextButton.innerHTML = translate.book_appointment;
                            });
                        }
                    } else {
                        tabToggleButtonEl.forEach(function (tab) {
                            nextButton.innerHTML = translate.next;
                        });
                    }

                    for (var i = 0; i < count; i += 1) {
                        tabToggleButtonEl[i].classList.add('done');
                    } //remove done class


                    for (var j = count; j < tabToggleButtonEl.length; j += 1) {
                        tabToggleButtonEl[j].classList.remove('done');
                    } // card footer remove at last step

                    if (count > 0) {
                        prevButton.classList.remove('d-none');
                    } else {
                        prevButton.classList.add('d-none');
                    }
                    if (count == 4) {
                        prevButton.classList.add('d-none');
                    }
                });
            });
        }
    }); // control wizard progressbar

    if (tabPillEl.length) {
        var dividedProgressbar = 100 / tabPillEl.length;
        tabProgressBar.querySelector('.progress-bar').style.width = "".concat(dividedProgressbar, "%");
        tabPillEl.forEach(function (item, index) {
            item.addEventListener('show.bs.tab', function () {
                tabProgressBar.querySelector('.progress-bar').style.width = "".concat(dividedProgressbar * (index + 1), "%");
            });
        });
    }
};

/* -------------------------------------------------------------------------- */

/*                                 Typed Text                                 */

/* -------------------------------------------------------------------------- */


var typedTextInit = function typedTextInit() {
    var typedTexts = document.querySelectorAll('.typed-text');

    if (typedTexts.length && window.Typed) {
        typedTexts.forEach(function (typedText) {
            return new window.Typed(typedText, {
                strings: utils.getData(typedText, 'typedText'),
                typeSpeed: 100,
                loop: true,
                backDelay: 1500
            });
        });
    }
};

docReady(wizardInit);
docReady(typedTextInit);
})(jQuery);
