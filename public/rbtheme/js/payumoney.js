(function($){
    "use strict";
    
    const payuButton = document.querySelector(".pay-payumoney");

    if(payuButton) {
        payuButton.addEventListener("click", function(e) {
            e.preventDefault();

            // ✅ Fetch price from selected service
            var selectService = document.querySelector("[data-wizard-validate-service]");
            var price = selectService.options[selectService.options.selectedIndex].getAttribute('data-price');
            const amount = price;

            // ✅ Use corrected jQuery selectors with fallback
            const firstname = $('input[name="first_name"]').val() || "Test";
            const email = $('input[name="email"]').val() || "test@example.com";
            const phone = $('input[name="phone"]').val() || "9999999999";
            const appointment_id = document.querySelector("#appointment_id").value || "";
            const productinfo = appointment_id || "Appointment Payment";

            // ✅ Fetch hash from backend (no changes)
            fetch('/payumoney/hash-generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: amount,
                    firstname: firstname,
                    email: email,
                    phone: phone,
                    productinfo: productinfo
                })
            })
            .then(res => res.json())
            .then(data => {
                bolt.launch({
                    key: data.key,
                    txnid: data.txnid,
                    hash: data.hash,
                    amount: amount,
                    firstname: String(firstname), // ✅ Make sure it's string
                    email: String(email),
                    phone: String(phone),
                    productinfo: productinfo,
                    udf1: "", // ✅ Optional data
                    surl: data.surl,
                    furl: data.furl,
                    mode: 'dropout',
                    //mode: 'popup',
                    pg: "ALL" // ✅ Ensures all payment options show up
                }, {
                    responseHandler: function(response){
                        // console.log("✅ Payment successful", response);
                        // // redirect or show confirmation

                        // $('#preloader').delay(100).fadeOut('slow', function() {
                        //     $(this).hide();
                        // });
                        // if(response.txnStatus == "SUCCESS") {
                        //     document.querySelector('#confirm-msg').innerHTML = '<p class="msg" style="color:#00d27a">Thank you! Your Booking is Successfully Booked</p>';
                        //     document.querySelector(".next-button").style.display = '';
                        //     setTimeout(() => {
                        //         alert("Success");
                        //         //window.location.href = data.redirect;
                        //     }, 1500);
                        // } else {
                        //     document.querySelector('#confirm-msg').innerHTML = '<p class="msg" style="color:#dc3545">'+response.txnMessage+'</p>';
                        //     setTimeout(() => {
                        //         alert("Failed");
                        //         window.location.reload(true);
                        //     }, 3500);
                        // }

                    },
                    catchException: function(error){
                        console.log("❌ Payment failed", error);
                    }
                });
            })
            .catch(error => {
                console.error("❌ Error fetching hash", error);
            });
        });
    }
})(jQuery);
