(function($) {
    "use strict";
    $(document).off("change", "input[type='checkbox']").on('change', "input[type='checkbox']", function(){
        var employee_id = $(this).data('employee_id');
        if(!$(this).is(':checked')){
            var status = 0;
        }else{
            var status = 1;
        }
        
        $.ajax({
            type:'POST',
            url: route('status'),
            headers: {'X-CSRF-TOKEN': _token },
            data: { id : employee_id,status : status },
            success: function(response){
                if(response.data) {
                    let alertElement = document.createElement('div');
                    alertElement.classList.add('alert');
                    alertElement.classList.add('alert-success');
                    alertElement.classList.add('custom-alert');
                    alertElement.innerHTML = translate.customer_update_status;
                    let target = document.querySelector(".board-title");
                    target.insertBefore(alertElement, null);
                    $('html, body').animate({scrollTop: $("html body").offset().top - 100}, "slow");
                    setTimeout(() => {
                        document.querySelector(".custom-alert").remove();
                    }, 2000);
                } 
            }
        });
    });
}(jQuery));