(function($) {
    "use strict";
    
    if($("#deleteItem .btn-delete").length) {
        $("#deleteItem .btn-delete").on('click', function(){
            Swal.fire({
                title: translate.are_you_sure,
                text: translate.able_to_revert_this,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonText: 'No, Cancel',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove it',
                }).then((result) => {
                if(result.isConfirmed) {
                    $("#deleteItem").submit();
                    Swal.fire(
                        translate.deleted,
                        translate.file_has_deleted,
                        'success'
                    )
                }
            })
        });
    }

    if ($('.btn-logout-click').length) {
        $(document).on('click','.btn-logout-click', function() {
            $('#logout-form').submit();
        })
    }

    $('.form').find('input, textarea').on('keyup blur focus', function (e) {
    
    var $this = $(this),
        label = $this.prev('label');

        if (e.type === 'keyup') {
                if ($this.val() === '') {
            label.removeClass('active highlight');
            } else {
            label.addClass('active highlight');
            }
        } else if (e.type === 'blur') {
            if( $this.val() === '' ) {
                label.removeClass('active highlight'); 
                } else {
                label.removeClass('highlight');   
                }   
        } else if (e.type === 'focus') {
        
        if( $this.val() === '' ) {
                label.removeClass('highlight'); 
                } 
        else if( $this.val() !== '' ) {
                label.addClass('highlight');
                }
        }

    });

    $('.tab a').on('click', function (e) {
        $('.container-of-errors').hide();
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        if(this.hash === '#login')
        {
            $('#signup').hide();
            $('#login').show();
        }
        else {
            $('#signup').show();
            $('#login').hide();
        }
    });

    $('#sign-up-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            headers: {'X-CSRF-Token': $('input[name=_token]').val()},
            type: "POST",
            url: this.action,
            data: $(this).serialize(),
            success: function (data) {
                location.href = data;
            },
            error: function (e) {
                $('.list-of-errors').empty();
                $('.container-of-errors').show();
                var errors = e.responseJSON.errors;
                var keys = Object.keys(errors);
                $.each(keys, function (index, value) {
                    $('.list-of-errors').empty();
                    var errors = e.responseJSON.errors;
                    var keys = Object.keys(errors);
                    $.each(keys, function (index, value) {
                        $('.list-of-errors').append('<li>'+value+':'+errors[value]+'</li>'+'<br>');
                    });
                });
            }
        });
    });

}(jQuery));