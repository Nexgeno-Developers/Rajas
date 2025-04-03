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
                            <div class="icon">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                            </div>
                            <h4>{{ __('Customers') }}</h4>

                            <div class="count-number">
                                <p>{{ $user }} <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                @if($custom->employees == 1)
                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('employees.index') }}">
                        <div class="monitor-box relative">
                            <div class="icon">
                                <i class="fa fa-user-secret" aria-hidden="true"></i>
                            </div>
                            <h4>{{ __('Employees') }}</h4>

                            <div class="count-number">
                                <p>{{ $employee }} <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('paymentlist') }}">
                        <div class="monitor-box relative">
                            <div class="icon">
                                <i class="fa fa-money" aria-hidden="true"></i>
                            </div>
                            <h4>{{ __('Total Payments') }}</h4>

                            <div class="count-number">
                                <p>{{ $payment }} <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                    <a href="{{ route('appointments.index').'?search=today' }}">
                        <div class="monitor-box relative">
                            <div class="icon">
                                <i class="fa fa-files-o" aria-hidden="true"></i>
                            </div>
                            <h4>{{ __('Bookings for today') }}</h4>

                            <div class="count-number">
                                <p>{{ $todayAppointment }} <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
                            
                            </div>
                        </div>
                    </a>
                </div>
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

