(function (wind, $) {
    "use strict";

        var sideMenuItemsToggle = function() {
            $(".nested-menu").hide();
            $(".toggle-menu").on("click",function(event){
                event.preventDefault();

                var $this = $(this);
                $this.next().toggle();

                var icon = $this.find('.icon .fa');

                if(icon.hasClass('fa-arrow-left')) {
                    icon.removeClass('fa-arrow-left');
                    icon.addClass('fa-arrow-down');
                } else if ( icon.hasClass('fa-arrow-down')) {
                    icon.removeClass('fa-arrow-down');
                    icon.addClass('fa-arrow-left');
                }

            });
        }, sideMenuToggle = function() {
                $('.bt-menu-trigger').on('click',function(){
                    $(this).toggleClass('bt-menu-open');

                    $('.aside').toggleClass('aside-toggle');
                    $('.dashboard-content').toggleClass('dashboard-toggle');

                });
        };

            sideMenuItemsToggle();
            sideMenuToggle();



    $(window).on('scroll',function(){
        var scroll = $(window).scrollTop();
        if (scroll > 15) {
            $(".navigation").css("background" , "black");
            $("nav").css("border-bottom" , "none","!important");
    
        }
    
        else{
            $(".navigation").css("background" , "transparent");
    
        }
    })
    $('a[href*="#"]')
        .not('[href="#"]')
        .not('[href="#tabBody1"]')
        .not('[href="#tabBody2"]')
        .on('click',function(event) {
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                &&
                location.hostname == this.hostname
            ) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000, function() {
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) {
                            return false;
                        } else {
                            $target.attr('tabindex','-1');
                            $target.focus();
                        };
                    });
                }
            }
        });
    
    setTimeout(function () {
        $('.alert-success').hide();
        $('.errors').hide();
    }, 3000);

    setTimeout(function () {
        $('.success').show();
        $('.errors').hide();
    }, 3000);
}(window, jQuery));
