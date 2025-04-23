<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
@if(!empty($site->site_title))
   <title>{{ $site->site_title }} | {{ $title }}</title>
@else
   <title>{{ __('Appointment Booking System') }} - {{ __('ReadyBook') }} | {{ $title }}</title>
@endif
@if(!empty($site->favicon))
   <link rel="icon" href="{{asset('img/favicons/'.$site->favicon)}}">
@else
   <link rel="icon" href="{{ asset('rbtheme/img/favicon.png') }}">
@endif
<link href="{{ asset('rbtheme/css/glyphicons.min.css')}}" rel="stylesheet">
<link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('backend/css/sidebar.css?ver=1.0')}}">
<link rel="stylesheet" href="{{ asset('backend/css/dashboard.css')}}">
<link rel="stylesheet" href="{{ asset('backend/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/base.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{ asset('backend/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('rbtheme/css/bootstrap-toggle.min.css')}}">
<link href="{{ asset('rbtheme/css/flatpickr.min.css') }}" rel="stylesheet" id="style-default">
<link rel="stylesheet" href="{{ asset('backend/css/intlTelInput.min.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
