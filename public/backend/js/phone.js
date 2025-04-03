(function($) {
    "use strict";
  
  const inputs = document.querySelectorAll(".country-phone-validation");
    inputs.forEach(function(input) {
        // const errorMsg = document.querySelector("#error-msg");
        // const validMsg = document.querySelector("#valid-msg");
        const eerrorMsg = input.parentElement.querySelector("#error-msg");
        const errorMsg = input.parentElement.querySelector("#error-msg");
        const validMsg = input.parentElement.querySelector("#valid-msg");
        let inputName = input.getAttribute('name');
        // here, the index maps to the error code returned from getValidationError - see readme
        const errorMap = [ translate.invalid_phone_number , translate.invalid_country_code , translate.phone_number_too_short , translate.phone_number_too_long, translate.invalid_phone_number ];
        if(errorMap){

        }
    
        let iti = window.intlTelInput(input, {
            initialCountry: input.dataset.name, //[input.dataset.name,input.dataset.code],
            utilsScript: "/intl-tel-input/js/utils.js?1683804567815",
            // hiddenInput: "phone",
        });

        const reset = () => {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            let customError = input.parentElement.parentElement.querySelector(".error");
            if(customError) customError.remove();
            errorMsg.classList.add("d-none");
            validMsg.classList.add("d-none");
            $('.btn-valid').removeAttr("disabled");

            var countryData = iti.getSelectedCountryData();
            if(inputName != "mobile") {
                $("#dialcode").val('+'+countryData.dialCode).attr('data-country', countryData.iso2);
                $('#iso2').val(countryData.iso2);
            } else if(inputName == "mobile") {
                $("#dialcodeR").val('+'+countryData.dialCode).attr('data-country', countryData.iso2);
                $('#iso2R').val(countryData.iso2);
            }
           
        };
    
    // on blur: validate
        input.addEventListener('blur', () => {
            reset();
            if (input.value.trim()) {
            if (iti.isValidNumber()) {
                let error = validMsg.parentElement.querySelector(".error");
                if(error == undefined || error.innerHTML == '')
                    validMsg.classList.remove("d-none");
            } else {
                let invalid = errorMsg.parentElement.querySelector(".error");
                if(invalid != undefined)
                    errorMsg.parentElement.querySelector(".error").remove();
                input.classList.add("error");
                const errorCode = iti.getValidationError();
                let errorHTML = (errorCode < 0) ? translate.please_enter_only_digits_numeric : errorMap[errorCode];
                errorHTML = (errorMap[errorCode] == undefined) ? translate.invalid_phone_number : errorHTML;
                errorMsg.innerHTML = errorHTML;
                errorMsg.classList.remove("d-none");
                $('.btn-valid').attr('disabled','disabled');
            }
            }
        });
        if ($('#dialcode').length && inputName != "mobile") {
            input.value = $('#dialcode').data('number');
        } else {
            input.value = $('#dialcodeR').data('number');
        }
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    });
}(jQuery));