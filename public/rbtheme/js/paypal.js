(function($){
"use strict";
paypal.Buttons({
    style: {
        layout: 'vertical',
        color: 'silver',
        shape: 'rect',
        label: 'pay',
    },
    onInit: function(data, actions) {

        // Listen for changes for to the checkbox
        document.querySelector("[name='payment_method']").addEventListener('change', function (event) {

            // Enable or disable the button when it is checked or  unchecked
            if(event.target.value == 'paypal') {// && event.target.checked) {
                actions.enable();
            } else {
                actions.disable();
            }
        });
    },
    onClick: function() {
        // Show a validation error if the checkbox is not checked
    },
    createOrder: (data, actions) => {
        var selectService = document.querySelector("[data-wizard-validate-service]");
        var amount = selectService.options[selectService.options.selectedIndex].getAttribute('data-price');
        return actions.order.create({
            purchase_units:[{
                amount: {
                    currency_code: 'USD',
                    value: amount
                }
            }]
        });
    },
    onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
            var appointment_id = document.querySelector('#appointment_id');
            if(orderData.status == 'COMPLETED' && orderData.intent == 'CAPTURE') {
                document.querySelector("#paypal-button-container").setAttribute('style','display:none;');
                $('#preloader').delay(100).fadeOut('slow', function() {
                    $(this).show();
                });
                fetch('/proceeds/paypal', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: _token,
                        appointment_id: appointment_id.value,
                        payment_id: orderData.id,
                        amount: orderData.purchase_units[0].amount.value,
                        currency: orderData.purchase_units[0].amount.currency_code
                    })
                }).then((response) => response.json())
                .then((data) => {
                    $('#preloader').delay(100).fadeOut('slow', function() {
                        $(this).hide();
                    });
                    if(data.error) {
                        document.querySelector('#confirm-msg').innerHTML = '<p class="msg" style="color:#dc3545">'+data.data+'</p>';
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 3500);
                    } else {
                        document.querySelector('#confirm-msg').innerHTML = '<p class="msg" style="color:#00d27a">'+data.data+'</p>';
                        document.querySelector("#book-button").removeAttribute('style');
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                })
                .catch((error) => {

                });

            }
        });
    },
    onCancel: (data) => {

    },
    onError: (err) => {

    }
}).render("#paypal-button-container");
})(jQuery);