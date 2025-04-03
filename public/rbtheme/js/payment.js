(function($){
"use strict";
const appearance = {
    theme: 'stripe'
};
const loader = 'auto';
const stripeModel = document.getElementById("stripemodal");
let stripe_key = document.getElementsByClassName('stripe_payment-data')[0].dataset.stripepopupkey;
stripeModel.addEventListener("shown.bs.modal", function() {
    
    const stripe = Stripe(stripe_key, { locale: 'en' });
    const cardButton = document.getElementById('card-button');
    var stripeButtion = document.getElementById("bootstrap-wizard-stripe");
    let clientSecret = cardButton.dataset.secret;
    const elements = stripe.elements({clientSecret, appearance, loader}); 
    const linkAuthentication = elements.create('linkAuthentication'); 
    const cardElement = elements.create('payment'); 
    cardElement.mount('#card-element'); 
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        $('#preloader').delay(100).fadeOut('slow', function() {
            $(this).show();
        });
        var appointment_id = document.getElementById("appointment_id").value;
        stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: SITEURL+'/'+appointment_id+'/appointment/payment/success'
            }
        }).then(function(result){
            $('#preloader').delay(100).fadeOut('slow', function() {
                $(this).hide();
            });
            if(result.error) {
                $("#stripemodal").modal('show');
            }
        });
    });
});

stripeModel.addEventListener('hidden.bs.modal', function() {
    $("#confirm-msg").html("<p style='color:red;'>"+translate.stripe_pay_and_confirm+"</p>");
    $("#book-button").hide();
    $(".pay-stripe").show();
});

$(document).off("click",".pay-stripe").on("click",".pay-stripe", function() {
    $("#stripemodal").modal('show');
});
})(jQuery);