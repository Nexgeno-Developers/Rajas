(function($) {
    "use strict";
    var rest = document.querySelector('#datetimepickerRest');
    var rest1 = document.querySelector('#datetimepickerRest1');
    let restConfig = {
        display: {
                icons: {
                type: 'icons',
                time: 'fa fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-arrow-up',
                down: 'fa fa-arrow-down',
                previous: 'fa-chevron-left',
                next: 'fa-chevron-right',
                today: 'fa-calendar-check',
                clear: 'fa fa-trash',
                close: 'glyphicon glyphicon-remove'
            },
            sideBySide: false,
            calendarWeeks: false,
            viewMode: 'clock',
            toolbarPlacement: 'top',
            keepOpen: true,
            buttons: {
                today: false,
                clear: true,
                close: true
            },
            components: {
                calendar: false,
                date: false,
                month: false,
                year: false,
                decades: true,
                clock: true,
                hours: true,
                minutes: true,
                seconds: false
            },
            inline: false,
            theme: 'auto'
        },
        stepping: 1,
        useCurrent: false,
        localization: {
            clear: 'Clear Selection',
            close: 'Close',
            pickHour: 'Select Hour',
            incrementHour:'Increase Hour',
            decrementHour:'Decrease Hour',
            pickMinute: 'Select Minute',
            incrementMinute:'Increase Minute',
            decrementMinute:'Decrease Minute',
            dateFormats: {
                LTS: 'h:m T',
                LT: 'h:m'
            },
            format: 'LT',
            hourCycle: 'h23'
        },
        keepInvalid: false,
        allowInputToggle: false,
        viewDate: new Date(),
        promptTimeOnDateChange: false,
        promptTimeOnDateChangeTransitionDelay: 200,
        meta: {},
        container: undefined
    };
    if(rest != null) {
        new tempusDominus.TempusDominus(rest,restConfig).subscribe(tempusDominus.Namespace.events.change, (e) => {
            if(e.date != undefined) {
                let dt = document.querySelector("#datetimepickerRest");
                dt.classList.remove("error");
                let list = dt.parentElement.querySelectorAll(".error");
                $.each(list, function(node, input) {
                    if(input.nodeName == 'LABEL')
                        input.remove();
                });
            }
        });
    }
    if(rest1 != null) {
        new tempusDominus.TempusDominus(rest1,restConfig).subscribe(tempusDominus.Namespace.events.change, (e) => {
            if(e.date != undefined) {
                let dt = document.querySelector("#datetimepickerRest1");
                dt.classList.remove("error");
                let list = dt.parentElement.querySelectorAll(".error");
                $.each(list, function(node, input) {
                    if(input.nodeName == 'LABEL')
                        input.remove();
                });
            }
        });
    }
    var rest2 = document.querySelector('#datetimepickerRest2');
    var rest3 = document.querySelector('#datetimepickerRest3');
    var rest4 = document.querySelector('#datetimepickerRest4');
    var rest5 = document.querySelector('#datetimepickerRest5');
    let restFullConfig = {
        display: {
            icons: {
                type: 'icons',
                time: 'fa fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-arrow-up',
                down: 'fa fa-arrow-down',
                previous: 'fa-chevron-left',
                next: 'fa-chevron-right',
                today: 'fa-calendar-check',
                clear: 'fa fa-trash',
                close: 'glyphicon glyphicon-remove'
            },
            sideBySide: false,
            calendarWeeks: false,
            viewMode: 'clock',
            toolbarPlacement: 'top',
            keepOpen: true,
            buttons: {
                today: false,
                clear: true,
                close: true
            },
            components: {
                calendar: false,
                date: false,
                month: false,
                year: false,
                decades: true,
                clock: true,
                hours: true,
                minutes: true,
                seconds: false
            },
            inline: false,
            theme: 'auto'
        },
        stepping: 1,
        useCurrent: false,
        localization: {
            clear: 'Clear Selection',
            close: 'Close',
            pickHour: 'Select Hour',
            incrementHour:'Increase Hour',
            decrementHour:'Decrease Hour',
            pickMinute: 'Select Minute',
            incrementMinute:'Increase Minute',
            decrementMinute:'Decrease Minute',
            dateFormats: {
                LTS: 'h:m T',
                LT: 'h:m'
            },
            format: 'LTS',
            hourCycle: 'h12'
        },
        keepInvalid: false,
        allowInputToggle: false,
        viewDate: new Date(),
        promptTimeOnDateChange: false,
        promptTimeOnDateChangeTransitionDelay: 200,
        meta: {},
        container: undefined
    };

    if(rest2 != null)
        new tempusDominus.TempusDominus(rest2,restFullConfig);
    if(rest3 != null)
        new tempusDominus.TempusDominus(rest3,restFullConfig);
    if(rest4 != null)
        new tempusDominus.TempusDominus(rest4,restFullConfig);
    if(rest5 != null)
        new tempusDominus.TempusDominus(rest5,restFullConfig);

    $(".timeDuration").keydown(function (event) {
        event.preventDefault();
    });
    
}(jQuery));