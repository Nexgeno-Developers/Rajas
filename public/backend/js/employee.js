/*function get_timeslots(el, category_id, service_id, employee_id) {

    if (!el.checked) {
        $('.timeslots_' + service_id).html('');
        return false;
    }

    var category_id = category_id;
    var service_id = service_id;
    var employee_id = employee_id;
    var selectedDate = new Date(Date.now() + 86400000).toISOString().split('T')[0];

    if(selectedDate != "" && employee_id != "") {

        $.ajax({
            url: '/timeslots2',
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

                            $.each(response.book_time, function(k, val) {

                                var start_time = moment(new Date(val.date+' '+val.start_time)).format('hh:mm A');
                                var end_time = moment(new Date(val.date+' '+val.finish_time)).format('hh:mm A');

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

                        html += `
                            <div class="col-md-4">
                                <label class="bookly-hour ${hide_slots}" style="display: block; cursor: pointer;">
                                    <input type="checkbox" name="timeslot[${service_id}][]" value="${value.start_time}-${value.end_time}">
                                    <span class="ladda-label bookly-time-main bookly-bold">
                                        <i class="bookly-hour-icon"><span></span></i>
                                        ${value.start_time} - ${value.end_time}
                                    </span>
                                    <span class="bookly-time-additional"></span>
                                </label>
                            </div>`;                        
                    });

                    if (response.slots.length == response.book_time.length){
                        $("#msg").append('<p class="booked_msg error">'+translate.selected_date_appointment_booked+'</p>');
                    }

                    $('.timeslots_' + service_id).html("<div class='row'>"+html+"</div>");

                } else {
                    $("#msg").append('<p class="booked_msg error">'+translate.booking_not_available+'</p>');
                    $("#time-slots").html('');
                }
            }
        });
    }
}*/

function get_timeslots(el, category_id, service_id, employee_id) {
    if (!el.checked) {
        $('.timeslots_' + service_id).html('');
        return false;
    }

    var selectedDate = new Date(Date.now() + 86400000).toISOString().split('T')[0];

    if(selectedDate != "" && employee_id != "") {
        $.ajax({
            url: '/timeslots2',
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

                    // Create an array of matched slot strings for easier comparison
                    var matchedSlotStrings = [];
                    if (response.matchedSlots && response.matchedSlots.length > 0) {
                        matchedSlotStrings = response.matchedSlots.map(function(slot) {
                            return slot.start_time + '-' + slot.end_time;
                        });
                    }

                    $.each(response.slots, function(key, value) {
                        var hide_slots = '';
                        var slotString = value.start_time + '-' + value.end_time;
                        var isMatched = matchedSlotStrings.includes(slotString);
                    
                        if(response.book_time.length > 0) {
                            $.each(response.book_time, function(k, val) {
                                var start_time = moment(new Date(val.date+' '+val.start_time)).format('hh:mm A');
                                var end_time = moment(new Date(val.date+' '+val.finish_time)).format('hh:mm A');

                                var slot_start_time = new Date(selectedDate+' '+value.start_time);
                                var slot_end_time = new Date(selectedDate+' '+value.end_time);

                                var google_start_time = new Date(val.date+' '+start_time);
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
                                } else if(s_end >= g_start && g_end >= s_start) {
                                    hide_slots = 'not-allowed'; 
                                    disabled = 'disabled';
                                    isMatched = false; // Don't check if slot is booked
                                }
                            }); 
                        }

                        html += `
                            <div class="col-md-4">
                                <label class="bookly-hour ${hide_slots}" style="display: block; cursor: pointer;">
                                    <input type="checkbox" name="timeslot[${service_id}][]" 
                                        value="${slotString}" 
                                        ${isMatched ? 'checked="checked"' : ''} 
                                        ${disabled}>
                                    <span class="ladda-label bookly-time-main bookly-bold">
                                        <i class="bookly-hour-icon"><span></span></i>
                                        ${value.start_time} - ${value.end_time}
                                    </span>
                                    <span class="bookly-time-additional"></span>
                                </label>
                            </div>`;                        
                    });

                    if (response.slots.length == response.book_time.length) {
                        $("#msg").append('<p class="booked_msg error">'+translate.selected_date_appointment_booked+'</p>');
                    }

                    $('.timeslots_' + service_id).html("<div class='row'>"+html+"</div>");

                } else {
                    $("#msg").append('<p class="booked_msg error">'+translate.booking_not_available+'</p>');
                    $("#time-slots").html('');
                }
            }
        });
    }
}


function employeeAjax(category_id, service_id) {
    $.ajax({
        type:'POST',
        url: route('categoryservice') ,
        headers: {'X-CSRF-TOKEN': _token },
        data: { category_id : category_id },
        success: function(response){
            var html = ' <label class="form-label">'+translate.services+' <span class="text-danger">*</span></label>';
            if(response.data){
                var html = ' <label class="form-label">'+translate.services+' <span class="text-danger">*</span></label>';
                jQuery.each(response.data, function(i, val) {
                    html += '<li class="row list-group-item d-flex">';
                    html += '<div class="col-md-10 p-0">'+val.name+'</div>';
                    html += '<div class="col-md-2 material-switch p-0 text-center">';
                    var checked = (service_id.includes(val.id)) ? "checked" : "";
                    html += '<input data-cat="'+val.category_id+'" data-ser="'+val.id+'" data-u="'+$('input[name="emp_id"]').val()+'" onchange="get_timeslots(this, '+val.category_id+', '+val.id+', '+$('input[name="emp_id"]').val()+')" value="'+val.id+'" name="service_id['+val.category_id+'][]" type="checkbox" data-check="service" data-duration="'+val.duration+'" '+checked+' /><label for="'+val.id+'" class="label-success"></label></div>';
                    html += `
                    <div class="bookly-time-step">
                            <div class="bookly-columnizer-wrap">
                                <div class="bookly-columnizer">
                                    <div class="bookly-time-screen">
                                        <div class="bookly-column bookly-js-first-column">
                                            <div id="time-slots" class="timeslots_${val.id}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div></li>`;
                });
                $("#service_id").html(html);

                //Loop through the response data and trigger get_timeslots
                jQuery.each(response.data, function(i, val) {
                    var checkbox = $('input[name="service_id['+val.category_id+'][]"][value="'+val.id+'"]');
                    get_timeslots(checkbox[0], val.category_id, val.id, $('input[name="emp_id"]').val());
                });
            }
        }
    });
}




function confirmGoogleCalendarAccess() {
    Swal.fire({
        title: translate.are_you_sure,
        text: translate.google_disconnect_message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonText: translate.google_no_cancel,
        cancelButtonColor: '#d33',
        confirmButtonText: translate.google_disconnected
        }).then((result) => {
        if(result.isConfirmed) {
        $("#removeItem").submit();
            Swal.fire(
                translate.disconnected,
                translate.google_disconnect_success,
                'success'
            ).then((result) => {
                    $(".remove-google span").remove();
                    $(".remove-google span").removeClass("employee-badge");
            });
        }
    })
}
function googleCalendarEmailConfirmation(e) {
    let dataRef = e.getAttribute('data-href');
    return Swal.fire({
        title: translate.google_calendar_email_confirmation,
        text: '',
        icon: 'info',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: translate.no,
        confirmButtonColor: '#3085d6',
        confirmButtonText: translate.yes
    }).then((result) => {
        if(result.isConfirmed) {
            $(".loader").show();
            window.location.replace(dataRef);
            return true;
        } else {
            return false;
        }
    });
}
    // function employeeAjax(category_id, service_id) {
    //     $.ajax({
    //         type:'POST',
    //         url: route('categoryservice') ,
    //         headers: {'X-CSRF-TOKEN': _token },
    //         data: { category_id : category_id },
    //         success: function(response){
    //             var html = ' <label class="form-label">'+translate.services+' <span class="text-danger">*</span></label>';
    //             if(response.data){
    //                 var html = ' <label class="form-label">'+translate.services+' <span class="text-danger">*</span></label>';
    //                 jQuery.each(response.data, function(i, val) {
    //                     html += '<li class="row list-group-item d-flex">';
    //                     html += '<div class="col-md-10 p-0">'+val.name+'</div>';
    //                     html += '<div class="col-md-2 material-switch p-0 text-center">';
    //                     var checked = (service_id.includes(val.id)) ? "checked" : "";
    //                     html += '<input value="'+val.id+'" name="service_id['+val.category_id+'][]" type="checkbox" data-check="service" data-duration="'+val.duration+'" '+checked+' /><label for="'+val.id+'" class="label-success"></label></div></li>';
    //                 });
    //                 $("#service_id").html(html);
    //             }
    //         }
    //     });
    // }


(function($) {
    "use strict";
    let serviceList = $(".servicesList").data('services');
    let customCategory = $(".customCategory").data('customcategory');
    let default_service_id = new Array();
    let default_cate_service = [];
    $.each(serviceList, function (key, val) {
        default_service_id.push(val.service_id);
        if (!default_cate_service[val.category_id]) {
            default_cate_service[val.category_id] = [];
        }
        default_cate_service[val.category_id].push(val.service_id);
    });
    var category_id = new Array();
    // var service_id = new Array();
    $("input[name='category_id[]']:checked").each(function() {
        category_id.push($(this).val());
    });
    // if (category_id != '') {
        // $.ajax({
        //     type:'POST',
        //     url: route('categoryservice'),
        //     headers: {'X-CSRF-TOKEN': _token },
        //     data: { category_id : category_id },
        //     success: function(response){
        //         if(response.data){
        //             var html = ' <label>'+translate.services+'</label>';
        //             jQuery.each(response.data, function(i, val) {
        //                 html += '<li class="list-group-item">';
        //                 html += val.name;
        //                 html += '<div class="material-switch pull-right">';
        //                 var checked = "";
        //                 $.each(default_service_id,function(index,value) 
        //                 {
        //                     if(value == val.id){
        //                         checked = 'checked';
        //                     }
        //                 });
        //                 html += '<input value="'+val.id+'" name="service_id['+val.category_id+'][]" data-check="service" type="checkbox" '+checked+' /> <label for="'+val.id+'" class="label-success"></label></div></li>';

        //             });
        //             $("#service_id").html(html);
        //         }   
        //     }
        // });

        employeeAjax(category_id, default_service_id);
    // }
    $(document).off("change", ".checkSingle").on("change", ".checkSingle", function() {
        if($("#checkedAll").is(":checked")) {
            $("#checkedAll").prop("checked", false);
        }
    });

    $(document).off("change", "input[type='checkbox']").on("change", "input[type='checkbox']", function() {
        var check = $(this).data('check');
        if(check === undefined) {
            if(!$(this).is(':checked')){
                var status = 0;
            }else{
                var status = 1;
            }
            var employee_id = $(this).data('employee_id');
            $.ajax({
                type:'POST',
                url: route('status'),
                headers: {'X-CSRF-TOKEN': _token },
                data: { id : employee_id,status : status },
                success: function(response){
                   if(response.data) {
                        let alertElement = document.createElement('div');
                        alertElement.classList.add('alert');
                        alertElement.classList.add('alert-success');
                        alertElement.classList.add('custom-alert');
                        alertElement.innerHTML = response.data;
                        let target = document.querySelector(".board-title");
                        target.insertBefore(alertElement, null);
                        $('html, body').animate({scrollTop: $("html body").offset().top - 100}, "slow");
                        setTimeout(() => {
                            document.querySelector(".custom-alert").remove();
                        }, 2000);
                   }
                    
                }
            });
        }
    });

    $("#checkedAll").on('change',function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $("input[name='category_id[]']:checkbox").on('change', function() {
        var check = $(this).data('check');
        if(check == "edit-categories") {
            var category_id = new Array();
            var service_id = new Array();
            var thiscat = $(this).val();
           
            if ($(this).is(':checked') == false) {
                $('input[name="service_id['+$(this).val()+'][]"]').prop('checked', false);    
            }
            $("input[name='category_id[]']:checked").each(function() {
                category_id.push($(this).val());
            });
            $('input[data-check="service"]:checked').each(function() {
                service_id.push(parseInt($(this).val()));
            });
            if ($(this).is(':checked') == true) {
                service_id = service_id.concat(default_cate_service[thiscat]);
            }
          
                // $.ajax({
                //     type:'POST',
                //     url: route('categoryservice') ,
                //     headers: {'X-CSRF-TOKEN': _token },
                //     data: { category_id : category_id ,},
                //     success: function(response){
                //         if(response.data){
                //             console.log(response.data);
                //             jQuery.each(response.data, function(i, val) {
                //                 html += '<li class="list-group-item">';
                //                 html += val.name;
                //                 html += '<div class="material-switch pull-right">';
                //                 var checked = (service_id.includes(val.id)) ? "checked" : "";
                //                 html += '<input value="'+val.id+'" name="service_id['+val.category_id+'][]" type="checkbox" data-check="service" '+checked+' /><label for="'+val.id+'" class="label-success"></label></div></li>';
                //             });
                //             $("#service_id").html(html);
                //         }
                //     }
                // });

                employeeAjax(category_id, service_id);
        }
    });

    $('form input[type=checkbox]').on('click', function(){
        $(this).parent().parent().siblings(".error-message").hide();
    });
        
    $("input[name='category_id[]']:checkbox").on('change', function() {
        var check = $(this).data('check');
        if(check == "categories") {
            console.log('cat');
            var category_id = new Array();
            var service_id = new Array();
            $("input[name='category_id[]']:checked").each(function() {
                category_id.push($(this).val());
            });
            $('input[data-check="service"]:checked').each(function() {
                service_id.push(parseInt($(this).val()));
            });
            
            // $.ajax({
            //     type:'POST',
            //     url: route('categoryservice'),
            //     headers: {'X-CSRF-TOKEN': _token },
            //     data: { category_id : category_id },
            //     success: function(response){
            //         if(response.data){
            //             var html = ' <label>'+translate.services+'</label>';
            //             jQuery.each(response.data, function(i, val) {
            //                 html += '<li class="list-group-item">';
            //                 html += val.name;
            //                 html += '<div class="material-switch pull-right">';
            //                 var checked = (service_id.includes(val.id)) ? "checked" : "";
            //                 html += '<input value="'+val.id+'" name="service_id['+val.category_id+'][]" data-check="service" type="checkbox" '+checked+'/><label for="'+val.id+'" class="label-success"></label></div></li>';
            //             });
            //             $("#service_id").html(html);
            //         }
            //     }
            // });

            employeeAjax(category_id, service_id);
            
        }
    });

    $(document).off("click","input[data-check='service']").on("click","input[data-check='service']",function(){
        var value = $(this, ':checked').attr('data-duration');
        if($(this).is(':checked') && value == '23:59:59') {
            $(".text-info").remove();
            $(this).parent().parent().parent().after("<span class='text-info'>"+translate.full_days_service+"</span>");
        }
        var checked = true;
        $("input[data-check='service']").each(function() {
            if($(this).is(':checked') && $(this).attr('data-duration') == '23:59:59')
                checked = false;
        });
        if(checked) {
            $(".text-info").remove();
        }
    });


    $('table tbody').on('click', '.remove-google', function(){
        confirmGoogleCalendarAccess();
    });
    
    $('.remove-google-access').on('click', function(){
        confirmGoogleCalendarAccess();
    });

    $(".next-button").on('click', function(){
        $("span.error").remove();
        if ($("label.error:visible").length) {
            return false;
        }
        var error = false;
        var first_name =  $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var password =  $('#password').val();
        var phone = $('#phone').val();	
        var start_time = $('#start_time').val();
        var finish_time = $('#finish_time').val();
        var rest_time = $('#rest_time').val();
        var break_start_time = $('#break_start_time').val();
        var break_end_time = $('#break_end_time').val();
        var currentDateObj = new Date();
        var date = currentDateObj.getFullYear() + "/" + (currentDateObj.getMonth() + 1) + "/" + currentDateObj.getDate();
        var startDate = new Date(date + " " + start_time);
        var endDate = new Date(date + " " + finish_time);
        var breakStartDate = new Date(date + " " + break_start_time);
        var breakEndDate = new Date(date + " " + break_end_time);
        var custom_padding = $('#rest_time').data('padding');
        var regex = /^\d+$/;
        var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var days = $('.emp-working-days').find('input:checked').length;
        if(first_name == ''){
            $('#first_name').after("<span class='error'>"+translate.please_enter_first_name+"</span>");
            error = true;
        } 
        if(last_name == ''){
            $('#last_name').after("<span class='error'>"+translate.please_enter_last_name+"</span>");
            error = true;
        }
        if(email == ''){
            $('#email').after("<span class='error'>"+translate.please_enter_the_email+"</span>");
            error = true;
        } 
        if(email != '' && emailRegex.test(email) == false) {
            $('#email').after("<span class='error'>"+translate.please_enter_valid_email+"</span>");
            error = true;
        }
        if(password == ''){
            $('#password').after("<span class='error'>"+translate.please_enter_password+"</span>");
            error = true;
        }
        if(phone == ''){
            $('#phone').parent().after("<span class='error'>"+translate.please_enter_phone_number+"</span>");
            error = true;
        }
        if(phone != '' && regex.test(phone) == false){
            $('#phone').parent().after("<span class='error'>"+translate.please_enter_only_digits_numeric+"</span>");
            error = true;
        }
        if(start_time == ''){
            $('#start_time').parent().after("<span class='error'>"+translate.please_enter_start_time+"</span>");
            error = true;
        } else if(startDate >= endDate) {
            $('#start_time').parent().after("<span class='error'>"+translate.start_time_before_end_time+"</span>");
            error = true;
        }
        if(finish_time == ''){
            $('#finish_time').parent().after("<span class='error'>"+translate.please_enter_end_time+"</span>");
            error = true;
        } else if(endDate <= startDate) {
            $('#finish_time').parent().after("<span class='error'>"+translate.end_time_after_start_time+"</span>");
            error = true;
        }
        if(rest_time == '' && custom_padding != 0 || custom_padding == undefined){
            $('#rest_time').parent().after("<span class='error'>"+translate.please_enter_rest_time+"</span>");
            error = true;
        }
        if(rest_time == '00:00') {
            $("#rest_time").parent().after("<span class='error'>"+translate.please_select_valid_rest_time+"</span>");
            error = true;
        }
        if(break_start_time != '' && breakStartDate >= breakEndDate && breakStartDate >= startDate){
            $('#break_start_time').parent().parent().find(".error").remove();
            $('#break_start_time').parent().after("<span class='error'>"+translate.break_start_before_break_end+"</span>");
            error = true;
        }
        if(break_end_time != '' && breakEndDate <= breakStartDate && breakEndDate <= endDate){
            $('#break_end_time').parent().parent().find(".error").remove();
            $('#break_end_time').parent().after("<span class='error'>"+translate.break_end_after_break_start+"</span>");
            error = true;
        }
        if(break_start_time != '' && startDate >= breakStartDate) {
            $('#break_start_time').parent().parent().find(".error").remove();
            $('#break_start_time').parent().after("<span class='error'>"+translate.break_start_time_after_start_time+"</span>");
            error = true;
        }
        if(break_start_time != '' && endDate <= breakStartDate) {
            $('#break_start_time').parent().parent().find(".error").remove();
            $('#break_start_time').parent().after("<span class='error'>"+translate.break_start_time_before_end_time+"</span>");
            error = true;
        }
        if(break_end_time != '' && breakEndDate >= endDate) {
            $('#break_end_time').parent().parent().find(".error").remove();
            $('#break_end_time').parent().after("<span class='error'>"+translate.break_end_time_before_end_time+"</span>");
            error = true;
        }
        if(break_end_time != '' && startDate >= breakEndDate) {
            $('#break_end_time').parent().parent().find(".error").remove();
            $('#break_end_time').parent().after("<span class='error'>"+translate.break_end_time_after_start_time+"</span>");
            error = true;
        }
        if(days <= 0){
            $('#checkedAll').parent().parent().parent().after("<span class='error'>"+translate.please_select_working_days+"</span>");
            error = true;
        }
        if(error == true){
            $('.next-page').hide();
            $('.current-page').show();
        } else {
            $('.next-page').show();
            $('.current-page').hide();
        }
    });
    $("input").on("keypress", function() {
        $(this).next("span").remove();
    });
    $('input.form-control:text').on('focus',function() {
        $(this).parent().next("span").hide();
    });
    $('input').on('click',function () {
        $(this).parent().parent().parent().next("span").hide();
    });
    $('.back-button-next').on('click', function(){
        $('.next-page').hide();
        $('.current-page').show();
    });

}(jQuery));