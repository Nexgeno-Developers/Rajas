$(document).ready(function () {

    if($('[name=country]').val()) {
        get_states($('[name=country]').val());
        $('.selectpicker').selectpicker('refresh');
    }

    $(document).on('change', '[name=country]', function() {
        var country_id = $(this).val();
        get_states(country_id);
        $('.selectpicker').selectpicker('refresh');
    });

    function get_states(country_id) {
        $('[name="state"]').html("");
        $.ajax({
            url: "/states",
            type: 'GET',
            data: {
                country_id  : country_id
            },
            success: function (response) {
                // Replace options
                const $stateSelect = $('[name="state"]');
                $stateSelect.empty(); 

                var obj = JSON.parse(response);

                //var obj = response;
                if(obj != '') {
                    $('[name="state"]').html(obj);
                    // Bootstrap-select fix
                    $stateSelect.selectpicker('destroy'); 
                    $stateSelect.selectpicker(); 
                    $stateSelect.trigger('change');
                }
            }
        });
    }

});