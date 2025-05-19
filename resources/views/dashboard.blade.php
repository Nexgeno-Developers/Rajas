@extends('layouts.app',['title' => trans('Dashboard')])
@section('head')
@include('includes.head',['title'=> trans('Dashboard')])
<link rel="stylesheet" href="{{asset('backend/css/tempus-dominus.min.css')}}">
<link rel="stylesheet" href="{{ asset('rbtheme/css/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{ asset('rbtheme/css/jquery.qtip.min.css')}}">
<link rel="stylesheet" href="{{ url('rbtheme/css/appointment-calender.css') }}">
@endsection
@section('content')
    @can('employees',\Illuminate\Support\Facades\Auth::user())
    <section class="monitor padding-space-half">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{route('customers.index')}}">
                        <div class="monitor-box relative">
                         <div class="count-number">
                                <p>{{ $user }}</p>
                            </div>
                        <div class="dashbaod_title">
                            <h4>{{ __('Customers') }}</h4>
                            <img src="{{asset('rbtheme/img/customer_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                            

                           
                        </div>
                    </a>
                </div>

                @if($custom->employees == 1)
                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('employees.index') }}">
                        <div class="monitor-box relative">
                          
                         <div class="count-number">
                                <p>{{ $employee }} </p>
                            </div>

                         <div class="dashbaod_title">
                           <h4>{{ __('Employees') }}</h4>
                            <img src="{{asset('rbtheme/img/employee_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                        </div>
                    </a>
                </div>
                @endif


                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('categories.index') }}">
                        <div class="monitor-box relative">
                             <div class="count-number">
                                <p>{{ $service }} </p>
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Total Services') }}</h4>
                            <img src="{{asset('rbtheme/img/payment_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                           
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('services.index') }}">
                        <div class="monitor-box relative">
                             <div class="count-number">
                                <p>{{ $Packages }} </p>
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Total Packages') }}</h4>
                            <img src="{{asset('rbtheme/img/payment_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                           
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('appointments.index') }}">
                        <div class="monitor-box relative">
                           
                           <div class="count-number">
                                <p>{{ $toatalBookings }}</p>
                            
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Total Bookings') }}</h4>
                            <img src="{{asset('rbtheme/img/date_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                            
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('appointments.index').'?search=approved' }}">
                        <div class="monitor-box relative">
                           
                           <div class="count-number">
                                <p>{{ $toatalBookings_approved }}</p>
                            
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Total Approved Bookings') }}</h4>
                            <img src="{{asset('rbtheme/img/date_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                            
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('appointments.index').'?search=cancel' }}">
                        <div class="monitor-box relative">
                           
                           <div class="count-number">
                                <p>{{ $toatalBookings_cancel }}</p>
                            
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Total Cancel Bookings') }}</h4>
                            <img src="{{asset('rbtheme/img/date_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                            
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('appointments.index').'?search=today' }}">
                        <div class="monitor-box relative">
                           
                           <div class="count-number">
                                <p>{{ $todayAppointment }}</p>
                            
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Bookings for today') }}</h4>
                            <img src="{{asset('rbtheme/img/date_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                            
                        </div>
                    </a>
                </div>
                

                {{-- <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('paymentlist') }}">
                        <div class="monitor-box relative">
                             <div class="count-number">
                                <p>{{ $payment }} </p>
                            </div>
                         <div class="dashbaod_title">
                           <h4>{{ __('Total Payments') }}</h4>
                            <img src="{{asset('rbtheme/img/payment_icons.svg')}}" class="img-fluid animated" alt="">
                        </div>
                           
                        </div>
                    </a>
                </div> --}}


            </div>
        </div>
    </section>
    @endcan
    <section class="board calendar padding-space-half">
        @if(Auth::user()->role_id != 3)
        {{-- ml-c-30 --}}
        <a href="{{ (Auth::user()->role_id == 2) ? route('book_now') : route('appointments.create') }}"><span class=""><button class="btn btn-default custom-btn btn-inline"> {{ __('ADD NEW') }}</button></span></a>
        @endif
        <div id="appointment-calendar"></div>
       
    </section>
@endsection
@section('scripts')
<script src="{{ asset('backend/js/tempus-dominus.min.js') }}"></script>
<script src="{{ asset('rbtheme/js/fullcalendar.min.js')}}"></script>
<script src="{{ asset('backend/js/appointment-list.js') }}"></script>
@endsection

