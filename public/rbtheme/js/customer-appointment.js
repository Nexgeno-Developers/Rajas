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
                    $.each(response.appointment, function(index, value) {
                        var color = '#17a2b8';
                        if(value.status == 'cancel') {
                            color = '#dc3545';
                        } else if(value.status == 'approved') {
                            color = '#28a745'; 
                        } else if(value.status == 'pending') {
                            color = '#ffc107';
                        }
                        eventsdata.push({
                            title: value.comments,
                            start: value.date+' '+value.start_time,
                            end: value.date+' '+value.finish_time,
                            url: route('customer-appointment', value.id), 
                            backgroundColor: color
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