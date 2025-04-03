(function($) {
"use strict";
    $.validator.addMethod("greaterThan", function(value, element, params) {
        var ele = element.getAttribute('name');
        if(value == '' && (ele == "break_start_time" || ele == "break_end_time")) return true;
        var currentDateObj = new Date();
        var date = currentDateObj.getFullYear() + "/" + (currentDateObj.getMonth() + 1) + "/" + currentDateObj.getDate();
        var startDate = new Date(date + " " + value);
        var endDate = new Date(date + " " + $(params).val());
        if(!/Invalid|NaN/.test(startDate)) {
            return startDate >= endDate;
        }
        return isNaN(value) && isNaN($(params).val())
            || (Number(value) > Number($(params).val()));
    }, $.validator.format('End Time Must be greater then start Time.'));

    $.validator.addMethod("lessThan", function(value, element, params) {
        var ele = element.getAttribute('name');
        if(value == '' && (ele == "break_start_time" || ele == "break_end_time")) return true;
        var currentDateObj = new Date();
        var date = currentDateObj.getFullYear() + "/" + (currentDateObj.getMonth() + 1) + "/" + currentDateObj.getDate();
        var startDate = new Date(date + " " + value);
        var endDate = new Date(date + " " + $(params).val());
        if(!/Invalid|NaN/.test(startDate)) {
            return endDate >= startDate;
        }
        return isNaN(value) && isNaN($(params).val())
            || (Number(value) > Number($(params).val()));
    }, $.validator.format('Start Time Must be less then End Time.'));

    $.validator.addMethod("betweenBreakTime", function(value, element, params) {
        if(element.value == '') return true;
        var currentDate = new Date();
        var nowDate = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getDate();
        var start = (params != undefined && params[0] != undefined) ? $(params[0]).val() : $("#start-time").val();
        var startDate = new Date(nowDate+" "+start);
        var end = (params != undefined && params[1] != undefined) ? $(params[1]).val() : $("#finish-time").val();
        var endDate = new Date(nowDate+" "+end);
        var currentValue = new Date(nowDate+" "+element.value);
        console.log(currentValue.getTime(), startDate.getTime(), currentValue.getTime() < endDate.getTime(), currentValue.getTime() > startDate.getTime());
        return currentValue.getTime() > startDate.getTime() && currentValue.getTime() < endDate.getTime();
    }, $.validator.format("Break Start Time Shoud be between Start Time and End Time"));

    $("#employeeServiceForm").validate({
        rules: {
            employee_id: "required",
            parent_user_id: "required",
            user_id: "required",
            start_time: {
                required: true,
                lessThan: "#finish-time"
            },
            finish_time: {
                required: true,
                greaterThan: "#start-time"
            },
            break_start_time: {
                lessThan: "#finish-time",
                betweenBreakTime: ["#start-time", "#finish-time"]
            },
            break_end_time: {
                greaterThan: "#start-time",
                betweenBreakTime: ["#start-time", "#finish-time"]
            },
            rest_time : {
                required: function() {
                    return $("#rest-time").attr("data-padding") != 0;
                }
            },
            position: {
                required: true
            },
            facebook: {
                required: true,
                url: true,
            },
            instagram: {
                required: true,
                url: true,
            },
            twitter: {
                required: true,
                url: true,
            },
            linkedin: {
                required: true,
                url: true,
            },
            "days[]": {
                required: true
            },
            "category_id[]": {
                required: true
            },
            "service_id[]": {
                required: true
            }
        },
        messages: {
            start_time: {
                required: translate.please_select_start_time,
                lessThan: translate.start_time_before_end_time,
            },
            finish_time: {
                required: translate.please_select_end_time,
                greaterThan: translate.end_time_after_start_time,
            },
            break_start_time: {
                lessThan: translate.break_time_after_start_time,
                betweenBreakTime: translate.break_time_between_start_end_time
            },
            break_end_time: {
                greaterThan: translate.break_time_before_end_time,
                betweenBreakTime: translate.break_time_between_start_end_time
            },
            rest_time : {
                required: translate.please_select_finish_rest_time
            },
            position: {
                required: translate.please_enter_job_title
            },
            facebook: {
                required: translate.please_enter_fackbook_link,
                url: translate.please_enter_valid_fackbook_link,
            },
            instagram: {
                required: translate.please_enter_instagram_link,
                url: translate.please_enter_valid_instagram_link,
            },
            twitter: {
                required: translate.please_enter_twitter_link,
                url: translate.please_enter_valid_twitter_link,
            },
            linkedin: {
                required: translate.please_enter_linkedin_link,
                url: translate.please_enter_valid_linkedin_link,
            },
            "days[]": {
                required: translate.please_select_working_days
            },
            "category_id[]": {
                required: translate.please_select_categories
            },
            "service_id[]": {
                required: translate.please_select_services
            }
        },
        errorPlacement: function(error, element) {
            if(element[0].name == 'rest_time') {
                error.appendTo(element.parent().parent());
            } else if(element[0].name == 'start_time') {
                error.appendTo(element.parent().parent());
            } else if(element[0].name == 'finish_time') {
                error.appendTo(element.parent().parent());
            } else if(element[0].name == 'break_start_time') {
                error.appendTo(element.parent().parent());
            } else if(element[0].name == 'break_end_time') {
                error.appendTo(element.parent().parent());
            } else if(element[0].type == 'checkbox') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        errorElement: "div",
        errorLabelContainer: ".errorTxt",
    });

    function employeeAjax(category_id, service_id) {
        $.ajax({
            type:'POST',
            url: route('service'),
            headers: {'X-CSRF-TOKEN': _token },
            data: { category_id : category_id },
            success: function(response){
                if(response.data){
                    var html = '';
                    jQuery.each(response.data, function(i, val) {
                        html += '<div class="form-check form-check-inline">';
                        var checked = (service_id.includes(val.id)) ? "checked" : "";
                        html += '<input class="form-check-input" type="checkbox" id="service-checkbox-'+val.id+'" value="'+val.id+'" data-check="service" data-duration="'+val.duration+'" name="service_id['+val.category_id+'][]" '+checked+'/>';
                        html+='<label class="form-label" for="service-checkbox-'+val.id+'">'+val.name+'</label></div></div>';
                    });
                    $("#service_id").html(html);
                }
            }
        });
    }
    $("input[name='category_id[]']:checkbox").on('change', function() {
        var category_id = new Array();
        var service_id = new Array();
        $("input[name='category_id[]']:checked").each(function() {
            category_id.push($(this).val());
        });
        $('input[data-check="service"]:checked').each(function() {
            service_id.push(parseInt($(this).val()));
        });
        if (category_id != '') {
            employeeAjax(category_id, service_id);
        }else{
            $("#service_id").html('');
        }
    });

    $(document).off("click",'input[data-check="service"]').on("click",'input[data-check="service"]',function(){
        var value = $(this, ':checked').attr('data-duration');
        if($(this).is(':checked') && value == '23:59:59') {
            $(".text-info").remove();
            $(this).parent().parent().after("<span class='text-info'>"+translate.full_days_service+"</span>");
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
})(jQuery);