(function($) {

    "use strict";

    window.onload = function() {

        $(".loader").hide();

    }

    let selectemptxt = $(".previous-serviceid").data('customfieldtext');

    function getEmployeeTimeslots() {

        var category_id = $("#speciality option:selected").data('id');

        var service_id = $("#service_id option:selected").data('id');

    
        var employee_id = $("#employee_id option:selected").val();

        var selectedDate = $("#adate").val();

        if(selectedDate != "" && employee_id != "") {

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

            }).done(function(response) {

                $("#msg").html('');

                var currentDate = new Date(selectedDate);

                var weekDays = response.workingDay;

                if(!weekDays.includes(currentDate.getDay().toString())) {

                    $("#msg").append('<p class="booked_msg error">'+translate.date_not_available+'</p>');

                    $("#time-slots").html('');

                } else {

                    if(response.slots.length > 0) {

                        var html = '';

                        var disabled = '';

                        $.each(response.slots, function(key, value) {

                            var hide_slots = '';
                        
                            if(response.book_time.length > 0) {

                                // console.log(response.book_time);

                                $.each(response.book_time, function(k, val) {

                                    var start_time = moment(new Date(val.date+' '+val.start_time)).format('hh:mm A');
                                    var end_time = moment(new Date(val.date+' '+val.finish_time)).format('hh:mm A');

                                    // ready book slot
                                   
                                    // if(start_time == value.start_time && end_time == value.end_time) {

                                    //     hide_slots = 'not-allowed'; 

                                    //     disabled = 'disabled';

                                    // }
                                    //end ready book slot

                                    //google booked slot

                                    var slot_start_time =  new Date(selectedDate+' '+value.start_time);
                                    var slot_end_time =  new Date(selectedDate+' '+value.end_time);

                                    var google_start_time =  new Date(val.date+' '+start_time);
                                    var google_end_time = new Date(val.date+' '+end_time);

                                    var g_start = google_start_time.getTime();
                                    var g_end = google_end_time.getTime();

                                    var s_start = slot_start_time.getTime();
                                    var s_end = slot_end_time.getTime();

                                    if(g_end == s_start){
                                        hide_slots = ''; 
                                        
                                    }
                                    else if(s_end == g_start){
                                        hide_slots = '';
                                       
                                    }else if(s_end >= g_start && g_end >= s_start ){
                                        hide_slots = 'not-allowed'; 
                                        disabled = 'disabled' ;
                                    }

                                    //end google booked slot
                                   
                                });   

                            }

                            if(response.slots.length == 1) {

                            html += '<div class="col-md-12">';

                            } else {

                            html += '<div class="col-md-4">';

                            }

                            html +='<button type="button" class="bookly-hour '+ hide_slots +'" data-value="'+value.start_time+'-'+value.end_time+'">';

                            html +='<span class="ladda-label bookly-time-main bookly-bold">';

                            html +='<i class="bookly-hour-icon"><span></span></i>';

                            html += value.start_time+' - '+value.end_time+'</span><span class="bookly-time-additional"></span></button></div>';

                        });

                       


                        if (response.slots.length == response.book_time.length){

                            $("#msg").append('<p class="booked_msg error">'+translate.selected_date_appointment_booked+'</p>');

                        }

                        $("#time-slots").html(html);

                    } else {

                        $("#msg").append('<p class="booked_msg error">'+translate.booking_not_available+'</p>');

                        $("#time-slots").html('');

                    }

                }

            });

        }

    }

    $("#service_id").on('change',function(){

        //alert(1);

        var check = $(this).data('check');

        if(check === undefined) {

            var selectedservice = $("#service_id option:selected").data('id');

            // var allowedWeight = $("#service_id option:selected").data('max-weight');
            // var allowedPerson = $("#service_id option:selected").data('max-person');

            // // Set the max attributes dynamically
            // $('#bootstrap-wizard-allowed-person').attr('max', allowedPerson);
            // $('#bootstrap-wizard-allowed-weight').attr('max', allowedWeight);

            // alert(allowedPerson + ' - '+ allowedWeight);            

            $.ajax({

                url: route('emp'),

                type: "POST",

                data: {id: selectedservice, _token: _token},

                dataType: "json",

            }).done(function(response) {
                $("#response").html(response.data);

                    $("#employee_id").html('');

                var employee = response.data;

                employee = JSON.stringify(employee);

                employee = JSON.parse(employee);

                var html = '';

                var selected = '';

                jQuery.each(response.data, function(i, val) {

                    if(i == 0) {

                        selected = 'selected';

                    } else {

                        selected = '';

                    }

                    html += "<option value='" + val.id + "' "+selected+">" + val.first_name + ' ' + val.last_name + "</option>";

                });

                $("#employee_id").html(html);


            });

            

        } 

    });



    $("#adate, #employee_id").on('change',function() {

        var employee_id = $("#employee_id option:selected").val();

        if(employee_id == "") {

            $(".list-of-errors").html('<li>'+translate.please_select+' '+selectemptxt+'</li>');

            $(".container-of-errors").show();

            return false;

        }

        getEmployeeTimeslots();

    });



    $(document).off("click",".bookly-hour").on("click",".bookly-hour",function() {
       
        var value = $(this).data('value');
       
        if(!$(this).hasClass("not-allowed")){

            $('.bookly-hour-active').removeClass('bookly-hour-active');

            $(this).addClass('bookly-hour-active');

            $("#time").val(value);

        }

    });

        

    $("#category_id").on('change',function(){ 

        var category_id = $("#category_id option:selected").data('id');

        $.ajax({

            url: route('getService'),

            type: "POST",

            data: {category: category_id, _token: _token},

            dataType: "json",

            }).done(function(response) {

            $("#response").html(response.data);

            $('#service_id').html('<option value="">'+translate.select_service+'</option>');

            $('#employee_id').html('<option value="">'+translate.select+' '+selectemptxt+'</option>');

            var service = response.data;
           
            jQuery.each(response, function(i, val) {

               // $("#service_id").append("<option value='" + val.name + "' data-id='"+ val.id +"'>" + val.name + "</option>");

               $("#service_id").append(
                    "<option value='" + val.name + "' " +
                    "data-id='" + val.id + "' " +
                    "data-max-weight='" + val.allowed_weight + "' " +
                    "data-max-person='" + val.no_of_person_allowed + "'>" +
                    val.name +
                    "</option>"
                );               

            });

        });

    });





    $("#submit").on('click', function (e) {

        if($("#formdata").valid()) {



            $(".loader").show();

            $.ajax({

                type: "POST",

                url: route('appointments.store'),

                data: $("#formdata").serialize(),

                dataType: 'json',

                success: function(response) {

                    $("#response").html(response.data);

                    if(response.status  == false) {

                        $(".container-of-errors").show();

                        $(".list-of-errors").html('<li>' + response.data + '</li>');

                    } else {

                        $(".loader").hide();

                        $(".container-of-success").show();

                        $(".list-of-success").html('<li>' + response.data + '</li>');

                        setTimeout(() => {

                            window.location.href = response.url;

                        }, 3000);

                    }

                },

                error: function(reject) {

                    $(".loader").hide();

                    $(".container-of-errors").show();

                    $(".error-message").html('');

                    $.each(reject.responseJSON.errors, function (key, value) {

                        $("#err-"+key).html(value[0]);

                    });

                }

            });

        }

    });



   

    $("select").on('change',function() {

        var key = $(this).attr('name');

        if (key == 'category_id' || key == 'service_id') {

            $("#err-service_id").html('');

            $("#err-employee_id").html('');

        }

        $("#err-"+key).html('');

    });



    $(document).on("click",".bookly-hour",function() {

        $("#err-slots").html('');

    });



    $("input, textarea").on('keyup change',function() {

        var key = $(this).attr('name');

        $("#err-"+key).html('');

    });



    var service_id = $("#service_id option:selected").data('id');

    let previous_service_id = $(".previous-serviceid").data('previous-serviceid');

    if(previous_service_id != ""){

        var selectedemp = "";

        $.ajax({

            url: route('emp'),

            type: "POST",

            data: {id: service_id, _token: _token},

            dataType: "json",

        }).done(function(response) {

            $("#response").html(response.data);

            $('#employee_id').html('<option value="">'+translate.select+' '+selectemptxt+'</option>');

            var employee = response.data;

            employee = JSON.stringify(employee);

            employee = JSON.parse(employee);

            jQuery.each(response.data, function(i, val) {

                if(val.id == previous_service_id) {

                    selectedemp = "selected"; 

                }

                $("#employee_id").append("<option value='" + val.id + "'" + selectedemp + ">" + val.first_name + ' ' + val.last_name + "</option>");

            });

        });

    }

    $("#service_id").on('change',function(){

        var check = $(this).data('check');

        if(check == 'service') {

            var selectedservice = $("#service_id option:selected").data('id');

            var allowedWeight = $("#service_id option:selected").data('max-weight');
            var allowedPerson = $("#service_id option:selected").data('max-person');

            // Set the max attributes dynamically
            $('#bootstrap-wizard-allowed-person').attr('max', allowedPerson);
            $('#bootstrap-wizard-allowed-weight').attr('max', allowedWeight);

            //alert(allowedPerson + ' - '+ allowedWeight);              

            $.ajax({

                url: route('emp'),

                type: "POST",

                data: {id: selectedservice, _token: _token},

                dataType: "json",

            }).done(function(response) {

                if(response.data == ''){

                    $('#employee_id').html('<option value="">'+translate.select+' '+selectemptxt+'</option>');

                }else{

                    $("#response").html(response.data);

                    var employee = response.data;

                    employee = JSON.stringify(employee);

                    employee = JSON.parse(employee);

                    var html = '';

                    var selected = '';

                    jQuery.each(response.data, function(i, val) {

                        if(i == 0) {

                            selected = 'selected';

                        } else {

                            selected = '';

                        }

                        html += "<option value='" + val.id + "' "+selected+">" + val.first_name + ' ' + val.last_name + "</option>";

                    });

                    $("#employee_id").html(html);

                    getEmployeeTimeslots();

                }

            });

        }

    });



    $("#cancel").validate({

        rules: {

            cancel_reason: "required",

        },

        messages: {

            cancel_reason: {

                required: translate.please_enter_cancel_reason

            },

        }

    });

    $('.back-btn-click').on('click', function() {

        window.location.href = route('dashboard');

    });

    $('#cancel').on("submit", function() {

        if ($('#cancel').valid()) {

            $('.loader').show();

        }

    });

    $('#complete').on("submit",function() {

        $('.loader').show();

    });

    $('#approved').on('click', function() {

        $('.loader').show();

    });

}(jQuery));