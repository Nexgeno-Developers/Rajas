(function($) {
    "use strict";
    
        $.ajax({
            type: 'POST',
            url: route('customer.appointments'),
            data: {_token: _token },
            dataType: 'json',
            async: true,
            success: function(response) {
                if(response.success) {
                    var eventsdata = [];
                    var object = {};
                    $.each(response.appointment, function(index, value) {
                        var color = '#17a2b8';
                        if(value.status == 'cancel') {
                            color = '#dc3545';
                        } else if(value.status == 'approved') {
                            color = '#60916f'; 
                        } else if(value.status == 'pending') {
                            color = '#b2902a';
                        }
                        eventsdata.push({
                            title: value.service_id + ' / ' + value.comments,
                            start: value.date+' '+value.start_time,
                            end: value.date+' '+value.finish_time,
                            url: route('appointments.show', value.id), 
                            backgroundColor: color,
                            // display: 'background'
                        });
                    });
                    var calendarEl = document.getElementById('appointment-calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,listWeek',
                        },
                        editable: true,
                        height:750,
                        events : eventsdata,
                    });
                    calendar.render();
                }
            }
        });
    
}(jQuery)); 