(function($) {
    'use strict';
    let CUSTOM_DATE_FORMAT = $(".custom-format").data('date-format');
    if(CUSTOM_DATE_FORMAT != undefined) {
        const config = {
        altInput: true,
        altFormat: CUSTOM_DATE_FORMAT,
        dateFormat: 'Y-m-d',
        minDate: 'today',
        maxDate: new Date().fp_incr(60)
        };
        $("#bootstrap-wizard-date").flatpickr(config);
    }
}(jQuery));