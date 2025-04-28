<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Appointment, Booking, System, Service, Categorie, Client, Customer, Employee">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta content="" name="description">
    @if(isset($site) && !empty($site->title))
    <title>{{ $site->site_title }} | {{ $title }}</title>
    @else
    <title>{{ __('Appointment Booking System') }} - {{ __('ReadyBook') }} | @yield('title')</title>
    @endif
    @if(!empty($site->logo))
    @php $fIconUrl = asset('img/favicons/'.$site->favicon) @endphp
    @else
    @php $fIconUrl = asset('rbtheme/img/favicon.png') @endphp
    @endif
    <link href="{{ $fIconUrl }}" rel="icon">
    <link href="{{ $fIconUrl }}" rel="apple-touch-icon">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $fIconUrl }}">
    <meta name="msapplication-TileImage" content="{{ $fIconUrl }}">
    @routes()
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/icofont.min.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/venobox.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/aos.css')}}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/toastr.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('rbtheme/css/loader.css') }}" rel="stylesheet" id="style-default">
    <link rel="stylesheet" href="{{ asset('backend/css/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ url('rbtheme/css/wizard.css?v='.time())}}">
    <link rel="stylesheet" href="{{ url('rbtheme/css/custom.css?v='.time())}}">
    <link href="{{ asset('rbtheme/css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('rbtheme/css/style.css?v='.time())}}" rel="stylesheet">
      @yield('css')
</head>

<body>

    @include('front.include.home-header')

    @yield('slider')
    <main id="main">
        <div class="container" data-layout="container">
            <div class="row flex-center min-vh-100 py-6 text-center">
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <div class="fw-black lh-1 text-300 fs-error">@yield('code')</div>
                                <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold w-md-75 w-xl-100 mx-auto">@yield('message')</p>
                                <hr/>
                                <p>{{ __("Make sure the address is correct and that the page hasn't moved. If you think this is a mistake.") }}</p><a class="btn btn-primary btn-sm mt-3" href="{{ route('welcome')}}"><span class="fas fa-home me-2"></span>{{ __('Take me home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer id="footer">
    @yield('footer-top')
    @include('front.include.home-footer')
    </footer>
    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>
    <script src="{{ asset('rbtheme/js/popper.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/jquery.min.js')}}"></script>
    <script src="{{ asset('rbtheme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('rbtheme/js/anchor.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/typed.js') }}"></script>
    <script src="{{ asset('rbtheme/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('rbtheme/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('rbtheme/js/venobox.min.js')}}"></script>
    <script src="{{ asset('rbtheme/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('rbtheme/js/aos.js')}}"></script>
    <script src="{{ asset('rbtheme/js/lodash.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/list.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/toastr.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/all.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('rbtheme/js/moment.min.js')}}"></script>
    <script src="{{ asset('backend/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('backend/js/intlTelInput-jquery.min.js') }}"></script>
    <script type="text/javascript">
        "use strict";
        var custom = "{{ (isset($custom) && isset($custom->categories)) ? $custom->categories : '' }}";
        let SITEURL = "{{  route('welcome')  }}";
        let _token = '{{ csrf_token () }}';
        let LOGGED = "{{  Auth::check()  }}";
        let langauge = "{{ app()->getLocale() }}";
        (function($) {
            "use strict";
            @if(Session::has('message'))
            toastr.success("{{Session::get('message')}}");
            @endif

            @if(Session::has('error-message'))
            toastr.error("{{Session::get('error-message')}}")
            @endif
        }(jQuery));
    </script>
    <script src="{{ asset('rbtheme/js/lang/'.app()->getLocale().'.js') }}"></script>
    <script src="{{ asset('rbtheme/js/custom.js?ver=1.1') }}"></script>
    @guest
    <script src="{{ asset('rbtheme/js/login.js')}}"></script>
    @endguest
    <script src="{{ asset('rbtheme/js/wizard.js') }}"></script>
    <script src="{{ asset('rbtheme/js/main.js') }}"></script>
    
    @yield('script')
    <script class="iti-load-utils" async src="{{ asset('backend/js/utils.js') }}"></script>
</body>

</html>