@extends('layouts.home',['title' => trans('Dashboard')])
@section('css')
<link rel="stylesheet" href="{{ asset('rbtheme/css/jquery.qtip.min.css')}}">
<link rel="stylesheet" href="{{ asset('rbtheme/css/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{ asset('rbtheme/css/appointment-calender.css') }}">
@endsection
@section('content')
<section class="py-0 overflow-hidden light" id="banner">
    <div class="bg-holder overlay">
    </div>
    <div class="container bg-light card mt-lg-7 mb-5 p-3">
        <div id='appointment-calendar' class="card-body"></div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('rbtheme/js/fullcalendar.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('rbtheme/js/jquery.qtip.min.js')}}"></script>
<script src="{{ asset('rbtheme/js/customer-appointment.js') }}"></script>
@endsection

