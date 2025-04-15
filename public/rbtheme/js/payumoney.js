// (function($){
//     "use strict";
    
//     const payuButton = document.querySelector(".pay-payumoney");

//     if(payuButton) {
//         payuButton.addEventListener("click", function(e) {
//             e.preventDefault();

//             // ✅ Fetch price from selected service
//             var selectService = document.querySelector("[data-wizard-validate-service]");
//             var price = selectService.options[selectService.options.selectedIndex].getAttribute('data-price');
//             const amount = price;

//             // ✅ Use corrected jQuery selectors with fallback
//             const firstname = $('input[name="first_name"]').val() || "Test";
//             const email = $('input[name="email"]').val() || "test@example.com";
//             const phone = $('input[name="phone"]').val() || "9999999999";
//             const appointment_id = document.querySelector("#appointment_id").value || "";
//             const productinfo = appointment_id || "Appointment Payment";

//             // ✅ Fetch hash from backend (no changes)
//             fetch('/payumoney/hash-generate', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json'
//                 },
//                 body: JSON.stringify({
//                     amount: amount,
//                     firstname: firstname,
//                     email: email,
//                     phone: phone,
//                     productinfo: productinfo
//                 })
//             })
//             .then(res => res.json())
//             .then(data => {
//                 bolt.launch({
//                     key: data.key,
//                     txnid: data.txnid,
//                     hash: data.hash,
//                     amount: amount,
//                     firstname: String(firstname), // ✅ Make sure it's string
//                     email: String(email),
//                     phone: String(phone),
//                     productinfo: productinfo,
//                     udf1: "", // ✅ Optional data
//                     surl: data.surl,
//                     furl: data.furl,
//                     mode: 'dropout',
//                     //mode: 'popup',
//                     pg: "ALL" // ✅ Ensures all payment options show up
//                 }, {
//                     responseHandler: function(response){
//                         console.log("✅ Payment successful", response);
//                     },
//                     catchException: function(error){
//                         console.log("❌ Payment failed", error);
//                     }
//                 });
//             })
//             .catch(error => {
//                 console.error("❌ Error fetching hash", error);
//             });
//         });
//     }
// })(jQuery);


(function($){
    "use strict";

    const payuButton = document.querySelector(".pay-payumoney");

    if(payuButton) {
        payuButton.addEventListener("click", function(e) {
            e.preventDefault();

            // ✅ Step 1: Get selected service
            const selectService = document.querySelector("[data-wizard-validate-service]");
            if (!selectService) {
                alert("Please select a service first.");
                return;
            }

            const selectedOption = selectService.options[selectService.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const appointment_id = document.querySelector("#appointment_id")?.value || "";

            if (!price || !appointment_id) {
                alert("Invalid service selection.");
                return;
            }

            // ✅ Step 2: Collect customer details
            const amount = String(price);
            const firstname = $('input[name="first_name"]').val() || "Test";
            const email = $('input[name="email"]').val() || "test@example.com";
            const phone = $('input[name="phone"]').val() || "9999999999";
            const productinfo = "Appointment #" + String(appointment_id); // Avoid numeric-only

            // ✅ Step 3: Get secure hash from backend
            fetch('/payumoney/hash-generate', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ amount, firstname, email, phone, productinfo })
            })
            .then(res => res.json())
            .then(data => {
                // ✅ Step 4: Validate data
                if (!data?.key || !data?.txnid || !data?.hash || !data?.surl || !data?.furl) {
                    console.error("Missing required Bolt params", data);
                    alert("Failed to initialize payment. Please try again.");
                    return;
                }

                // ✅ Step 5: Launch Bolt Dropout UI
                if (typeof bolt !== 'undefined') {
                    bolt.launch({
                        key: String(data.key),
                        txnid: String(data.txnid),
                        hash: String(data.hash),
                        amount: String(amount),
                        firstname: String(firstname),
                        email: String(email),
                        phone: String(phone),
                        productinfo: String(productinfo),
                        udf1: "",
                        surl: String(data.surl),
                        furl: String(data.furl),
                        mode: 'dropout',
                        pg: "ALL"
                    }, {
                        responseHandler: function(response) {
                            console.log("✅ Payment success response", response);
                            // Optional: redirect manually or wait for server callback
                        },
                        catchException: function(error) {
                            console.error("❌ Bolt exception", error);
                            alert("Payment failed: " + (error.error_Message || "Unknown error"));
                        }
                    });
                } else {
                    alert("Payment system not loaded. Please refresh and try again.");
                }
            })
            .catch(error => {
                console.error("❌ Hash generation failed", error);
                alert("Something went wrong. Try again later.");
            });
        });
    }
})(jQuery);
