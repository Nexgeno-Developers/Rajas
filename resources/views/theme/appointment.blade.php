@extends('layouts.home',['title' => trans('Appointment')])
@section('css')
<link rel="stylesheet" href="{{ asset('rbtheme/css/booking-slots.css')}}">
<link href="{{ asset('rbtheme/css/flatpickr.min.css') }}" rel="stylesheet" id="style-default">
@endsection
@section('content')
<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="zluck-container" id="banner">
    <div class="container justify-content-center" data-layout="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-lg-9 col-xxl-7 mb-5">
            
                <div class="d-flex flex-center mb-5">
                    <span class="font-sans-serif fw-bolder fs-4 d-inline-block">{{ __('Book Appointment') }}</span>
                </div>
                
                <div class="card theme-wizard mb-5" id="wizard">
                    <form class="needs-validation" novalidate="novalidate" id="formdata" method="POST"
                        id="appointment-form" action="{{ route('appointment.create') }}" autocomplete="off">
                        @csrf
                        <div class="card-header bg-light pt-3 pb-2 p-0">
                            <ul class="nav justify-content-between nav-wizard">
                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab1" data-bs-toggle="tab"
                                        data-wizard-step="data-wizard-step" data-winzard-id="0"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                                    class="fas fa-lock"></span></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">{{ __('Service') }}</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"
                                        data-winzard-id="1"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><span
                                                    class="fas fa-clock"></span></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">{{ __('Time') }}</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"
                                        data-winzard-id="2"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><span
                                                    class="fas fa-user"></span></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">{{ __('Details') }}</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"
                                        data-winzard-id="3"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle">{{$custom->currency_icon}}</span></span><span
                                            class="d-none d-md-block mt-1 fs--1">{{ __('Billing') }}</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                        data-bs-toggle="tab" data-wizard-step="data-wizard-step"
                                        data-winzard-id="4"><span class="nav-item-circle-parent"><span
                                                class="nav-item-circle"><span
                                                    class="fas fa-thumbs-up"></span></span></span><span
                                            class="d-none d-md-block mt-1 fs--1">{{ __('Done') }}</span></a></li>
                            </ul>
                        </div>
                        <div class="card-body py-3" id="wizard-controller">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                                    <div class="mb-1 h-20">
                                        <span id="employee_msg" class="employee_book-msg"></span>
                                    </div>
                                    @if($custom->categories == 1)
                                    <div class="mb-3">
                                        <label class="form-label custom-category"
                                            for="bootstrap-wizard-category" data-custom-category="{{ucfirst($custom->custom_field_category)}}">{{ucfirst($custom->custom_field_category)}}<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control form-select" name="category_id" id="bootstrap-wizard-category"
                                            data-wizard-validate-category="true"  required="required">

                                            <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_category)}}
                                            </option>
                                            @foreach ($categories as $row)
                                            <option value="{{$row->name}}" data-id="{{$row->id}}">{{ $row->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">{{ __('Please Select') }}
                                            {{ucfirst($custom->custom_field_category)}}</div>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label custom-service"
                                            for="bootstrap-wizard-service" data-custom-service="{{ucfirst($custom->custom_field_service)}}">{{ucfirst($custom->custom_field_service)}}<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control form-select" name="service_id" id="bootstrap-wizard-service"
                                            data-wizard-validate-service="true" required="required">
                                            <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_service)}}
                                            </option>
                                            @if($custom->categories != 1)
                                                @foreach ($services as $service)
                                                <option value="{{$service->name}}" data-id="{{$service->id}}" data-price="{{ $service->price }}" data-tax="{{ $service->tax }}" data-price-excluded-tax="{{ Helper::removeTax($service->price, $service->tax) }}" data-allowed-weight="{{ $service->allowed_weight }}" data-allowed-person="{{ $service->no_of_person_allowed }}">
                                                    {{ ucfirst($service->name) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">{{ __('Please Select') }}
                                            {{ucfirst($custom->custom_field_service)}}</div>
                                    </div>

                                @if($custom->employees == 1)
                                    <div class="mb-3"><label class="form-label custom-employee"
                                            for="bootstrap-wizard-employee" data-custom-employee="{{ucfirst($custom->custom_field_text)}}">{{ucfirst($custom->custom_field_text)}}<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control form-select"
                                            name="employee_id" id="bootstrap-wizard-employee"
                                            data-wizard-validate-employee="true" required="required">   
                                            <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_text)}}</option>
                                        </select>
                                        <div class="invalid-feedback">{{ __('Please Select') }}
                                            {{ucfirst($custom->custom_field_text)}}</div>
                                    </div>
                                @elseif($custom->employees == 0)
                                    <input type="hidden" class="input-field employee_name" id="bootstrap-wizard-employee" data-wizard-validate-employee="true" name="employee_id" 
                                    data-employee="{{ $admin->first_name.' '.$admin->last_name }}" value="{{ $admin->id }}">
                                @endif
                                    
                                    <div class="mb-3"><label class="form-label" for="bootstrap-wizard-date">{{ __('Date') }}<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control custom-format" type="text" name="date" value="{{date('Y-m-d')}}" required="required" autocomplete="off"
                                            id="bootstrap-wizard-date" placeholder="{{ __('Booking Date') }}" data-date-format="{{ $custom->date_format }}"
                                            data-wizard-validate-date="true" />
                                        <div class="invalid-feedback">{{ __('Please Select Date') }}</div>
                                    </div>
                                </div> 
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                    <p>{{ __('Below you can find list of available time slots for') }} <b
                                            class="service_name">{{ __('Service name') }} </b> 
                                    @if($custom->employees == 1)
                                    {{ __('by') }} <b class="employee_name emp-cap">{{ __('Employee Name') }} </b>
                                    @endif
                                    </p>
                                    <p>{{ __('Select time slot for booking') }}</p>
                                    <p id="msg" class="book-msg"></p>
                                    <input type="hidden" name="slots" id="time" value=""
                                        data-wizard-validate-slot="true" required="required">
                                    <div class="invalid-feedback">{{ __('Please Select slot') }}</div>
                                    <label for="" class="text-custom">{{ __('Appointment Time') }}<span
                                            class="text-danger">*</span></label>
                                    <div class="bookly-time-step">
                                        <div class="bookly-columnizer-wrap">
                                            <div class="bookly-columnizer">
                                                <div class="bookly-time-screen">
                                                    <div class="bookly-column bookly-js-first-column">
                                                        <div class="row" id="time-slots">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="error time-error text-danger"></span>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                    <span class="text-danger" id="email-check"></span>
                                    <p>{{ __("You've selected") }} <b class="service_name">{{ __('Service Name') }}</b> {{ __('service from') }} <b
                                            class="booking_time">{{ __('Booking') }}
                                            {{ __('Time') }}</b> {{ __('on') }} <b class="booking_date">{{ __('Booking Date') }}</b>. {{ __("you'll be charged by") }}
                                        <b class="custom-currency" data-custom-currency="{{strtoupper($custom->currency)}}">{{$custom->currency_icon}}</b><b class="booking_price">{{ __('1.00') }}</b>.
                                    </p>
                                    <p>{{ __('Please provide your details in the form below to proceed with booking.') }}</p>
                                    <div class="row g-2">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-first-name">{{ __('First Name') }}<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="first_name" @auth
                                                    value="{{auth()->user()->first_name}}"
                                                    disabled @endauth placeholder="{{ __('Enter First Name') }}"
                                                    data-wizard-validate-first-name="true" id="bootstrap-wizard-first-name"
                                                    required="required" autocomplete="off" />
                                                <div class="invalid-feedback">{{ __('Please enter the first name') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-last-name">{{ __('Last Name') }}<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="last_name" @auth
                                                    value="{{auth()->user()->last_name}}"
                                                    disabled @endauth placeholder="{{ __('Enter Last Name') }}"
                                                    data-wizard-validate-last-name="true" id="bootstrap-wizard-last-name"
                                                    required="required" autocomplete="off" />
                                                <div class="invalid-feedback">{{ __('Please enter the last name') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ old('country_name') }}">

                                    <input type="hidden" name="country_code" id="dialcode" class="country_code" value="{{ old('country_code') }}" data-country="{{ old('country_name') }}" 
                                    @auth data-number="{{ Auth::user()->phone }}" @endauth @guest data-number="{{ old('phone') }}" @endguest>
                            
                                    <div class="row g-2">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Phone') }}<span
                                                        class="text-danger">*</span></label>
                                                <input autocomplete="off" class="form-control intlTelInput country-phone-validation" type="tel" name="phone" 
                                                @auth value="{{ Auth::user()->phone }}" disabled @endauth @guest value="" @endguest
                                                    placeholder="{{ __('Enter Phone') }}" required="required"
                                                    id="bootstrap-wizard-phone" data-wizard-validate-phone="true" data-name="{{ Auth::user()->country_name ?? $site->country_name }}"/>
                                                <div class="invalid-feedback phone-error">{{ __('Please enter the phone number') }}</div>
                                                <span id="valid-msg" style="color: green;" class="d-none">✓ {{ __('Phone Number Valid') }}</span>
                                                <span id="error-msg" style="color: #bd5252;" class="d-none"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-email">{{ __('Email') }}<span
                                                        class="text-danger">*</span></label>
                                                <input autocomplete="off" class="form-control" type="email" name="email" id="email"
                                                    placeholder="{{ __('Email address') }}" @auth value="{{auth()->user()->email}}"
                                                    readonly @endauth
                                                    required="required" id="bootstrap-wizard-wizard-email"
                                                    data-wizard-validate-email="true" />
                                                <div class="invalid-feedback email-error">{{ __('Please enter the email') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" @auth @if(auth()->user()->country) style="pointer-events:none;" @endif @endauth>
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Country') }}<span class="text-danger">*</span></label>
                                                <select autocomplete="off" class="form-control rounded-0 selectpicker" data-wizard-validate-country="true" data-live-search="true" data-placeholder="{{ __('Select your country') }}" name="country" placeholder="Select Country" required="required" >
                                                    <option value="">{{ __('Select your country') }}</option>
                                                    @foreach (Helper::get_active_countries() as $key => $country)
                                                    {{--<option value="{{ $country->id }}" @auth @if(auth()->user()->country == $country->id) selected @elseif($country->id == 101) selected @endif @endauth>{{ $country->name }}</option>--}}
                                                    <option value="{{ $country->id }}"
                                                        @if(auth()->check() && auth()->user()->country == $country->id)
                                                            selected
                                                        @elseif(!auth()->check() && $country->id == 101)
                                                            selected
                                                        @elseif(auth()->check() && !auth()->user()->country && $country->id == 101)
                                                            selected
                                                        @endif>
                                                        {{ $country->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('Please select the country') }}</div>                                                         
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" @auth @if(auth()->user()->state) style="pointer-events:none;" @endif @endauth>
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('State') }}<span class="text-danger">*</span></label>
                                                <select autocomplete="off" class="form-control rounded-0 @if(auth()->check() && !auth()->user()->state) selectpicker @endif" data-wizard-validate-state="true" data-live-search="true" name="state" required="required" placeholder="Select State">

                                                </select>  
                                                <div class="invalid-feedback">{{ __('Please select the state') }}</div>                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Number of Person') }}<span class="text-danger">*</span></label>
                                                <input autocomplete="off" step="1" min="1" max="" class="form-control" type="number" name="no_of_person_allowed" placeholder="{{ __('Enter Number of Person') }}"
                                                    data-wizard-validate-allowed-person="true" id="bootstrap-wizard-allowed-person" required />
                                                <div class="invalid-feedback">{{ __('Please enter the number of person') }}</div>                                    
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Total Weight') }}<span class="text-danger">*</span></label>                                            
                                                <input autocomplete="off" step="1" min="1" max="" class="form-control" type="number" name="allowed_weight" placeholder="{{ __('Enter Weight') }}"
                                                    data-wizard-validate-allowed-weight="true" id="bootstrap-wizard-allowed-weight" required />
                                                <div class="invalid-feedback">{{ __('Please enter the weight') }}</div>                                             
                                            </div>
                                        </div>
                                    </div>                                     

                                    <div class="row g-2">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-none">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('City') }}</label>
                                                <input class="form-control" type="text" name="city" @auth
                                                    value="{{auth()->user()->city}}"
                                                    @if(auth()->user()->city) readonly @endif @endauth placeholder="{{ __('Enter City') }}"
                                                    data-wizard-validate-city="true" id="bootstrap-wizard-city" />
                                                <div class="invalid-feedback">{{ __('Please enter the city name') }}</div>                                    
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-none">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Zipcode') }}</label>                                            
                                                <input class="form-control" type="text" name="zipcode" @auth
                                                    value="{{auth()->user()->zipcode}}"
                                                    @if(auth()->user()->zipcode) readonly @endif @endauth placeholder="{{ __('Enter Zipcode') }}"
                                                    data-wizard-validate-zipcode="true" id="bootstrap-zipcode" />
                                                <div class="invalid-feedback">{{ __('Please enter the zipcode') }}</div>                                             
                                            </div>
                                        </div>
                                    </div>    
                                    
                                    <div class="row g-2">
                                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Goverment ID Number') }} <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="goverment_id" @auth
                                                    value="{{auth()->user()->goverment_id}}"
                                                    @if(auth()->user()->goverment_id) readonly @endif @endauth placeholder="{{ __('Enter Goverment ID Number') }}"
                                                    data-wizard-validate-goverment-id="true" id="bootstrap-wizard-goverment-id" required />
                                                <div class="invalid-feedback">{{ __('Please enter the Goverment ID Number') }}</div>                                    
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="mb-3"><label class="form-label"
                                            for="bootstrap-wizard-detail">{{ __('Detail') }}<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" name="comments"
                                            id="bootstrap-wizard-detail" data-wizard-validate-detail="true"
                                            placeholder="{{ __('Appointment booking detail') }}" required="required"></textarea>
                                        <div class="invalid-feedback">{{ __('Please enter the appointment booking detail') }}</div>
                                    </div>
                                </div>
                                <div class="tab-pane  px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                    <p> <b>{{ __('Select Payment method') }}</b><span class="text-danger">*</span></p>
                                    <p id="stripe-msg"></p>
                                    <input type="hidden" id="appointment_id" value="">
                                    <input type="hidden" name="payment_method" value="" id="payment_method" data-wizard-validate-payment="true">                               
                                    <div class="row flex-center payment-options">

                                        <!-- New -->
                                        <div class="col-md-3 px-card  payment-card">
                                            <div class="payment-container">
                                                <span class="payment-image">
                                                    <img class="landing-cta-img payment_method payumoney_popup_data" src="{{ asset('rbtheme/img/payumoney.png')}}" alt=""  data-value="payumoney"
                                                    data-payumoneyPopupKey="">
                                                </span>
                                                <span class="payment-label">{{ __('PayUmoney') }}</span>
                                            </div>  
                                        </div>

                                        @if($custom->is_stripe == 1)   
                                        <div class="col-md-3 px-card  payment-card" id="bootstrap-wizard-stripe">
                                            <div class="payment-container">
                                                <span class="payment-image">
                                                    <img class="landing-cta-img payment_method stripe_payment-data" src="{{ asset('rbtheme/img/stripe-logo.png')}}"  alt="" data-value="stripe"
                                                    data-stripePopupKey="{{($custom->stripe_active_mode == 1) ? $custom->stripe_live_key : $custom->stripe_key }}">
                                                </span>
                                                <span class="payment-label">{{ __('Stripe') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        @if($custom->is_razorpay == 1)
                                        <div class="col-md-3 px-card  payment-card">
                                            <div class="payment-container">
                                                <span class="payment-image">
                                                    <img class="landing-cta-img payment_method razorpay_popup_data" src="{{ asset('rbtheme/img/Razorpay.png')}}" alt=""  data-value="razorpay"
                                                    data-razorpayPopupKey="{{ ($custom->razorpay_active_mode == 1) ? $custom->razorpay_live_key : $custom->razorpay_test_key }}">
                                                </span>
                                                <span class="payment-label">{{ __('Razorpay') }}</span>
                                            </div>  
                                        </div>
                                        @endif
                                        @if($custom->is_paypal == 1)
                                        <div class="col-md-3 px-card  payment-card">
                                            <div class="payment-container">
                                                <span class="payment-image">
                                                    <img class="landing-cta-img payment_method" src="{{ asset('rbtheme/img/paypal.webp')}}" alt="" data-value="paypal">
                                                </span>
                                                <span class="payment-label">{{ __('PayPal') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        @if($custom->is_payment_later == 1)
                                        <div class="col-md-3 px-card  payment-card">
                                            <div class="payment-container">
                                                <span class="payment-image">
                                                    <img class="landing-cta-img payment_method custom-logo" src="{{ asset('rbtheme/img/COD.png')}}" alt="" data-value="offline">
                                                </span>
                                                <span class="payment-label">{{ __('Pay Later') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        <fieldset class="custom_site-data" data-custom-logo="{{ (isset($custom) && !empty($custom->logo)) ? asset("img/logo/".$custom->logo) : asset("rbtheme/img/logo.png")}}" data-site-title="{{ (isset($site) && !empty($site->site_title)) ? $site->site_title : 'Rozarpay' }}"></fieldset>
                                    </div>
                                </div>

                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5">
                                    <div class="row text-center">
                                        <div class="col-12 col-md-12">
                                            <span class="countdown d-none">{{ __('Complete your payment process within') }} : <span class="timeleft"></span></span>                  
                                            <p id="confirm-msg"></p>
                                            <p id="confirm-detail"> {{ __('Please confirm your appointment booking details once before proceed') }}.</p>
                                            @if($custom->smtp_mail == 1)
                                            <p>{{ __("We'll send booking details via an email to you at") }}  <span class="user_email f-700"></span></p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        @if($custom->categories == 1)
                                        <div class="col-6 col-md-6">
                                            <div class="row">
                                                <div class="col-2 col-md-2">
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/category.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ucfirst($custom->custom_field_category)}}</label></p> 
                                                        <span><label class="category_name f-700 img-detail"></label></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-6 col-md-6">
                                            <div class="row">
                                                <div class="col-2 col-md-2">
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/service.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ucfirst($custom->custom_field_service)}}</label></p>
                                                        <span><label class="service_name f-700 img-detail"></label></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-2 col-md-2"> 
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/price.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ucfirst($custom->custom_field_service)}} {{ __('Fees') }}</label></p>
                                                        <span class="f-700 img-price">{{ $custom->currency_icon }}</span>
                                                        <span class="booking_price f-700 img-price"></span></label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($custom->employees == 1)
                                        <div class="col-6 col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-2 col-md-2">
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/employee.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ucfirst($custom->custom_field_text)}}</span></label></p>
                                                        <span><label class="employee_name f-700 img-detail"></label></span>
                                                    </span>   
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-6 col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-2 col-md-2">
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/date.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ __('Other Information') }}:</label></p>
                                                        <span><label class="other_information f-700 img-detail "></label></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                                        

                                        <div class="col-6 col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-2 col-md-2">
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/date.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ __('Appointment Date') }}:</label></p>
                                                        <span><label class="booking_date f-700 img-detail "></label></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-6 col-md-6  @if($custom->categories != 1) mr-auto @endif">
                                            <div class="row mt-3">
                                                <div class="col-2 col-md-2">
                                                    <span><img class="detail-img " src="{{ asset('rbtheme/img/time-appointment.jpg')}}" alt="" height="50px" width="50px"></span>
                                                </div>
                                                <div class="col-10 col-md-10">
                                                    <span class="text-custom">
                                                        <p class="p-space"><label class="f-700 label-color">{{ __('Appointment Time') }}:</label></p>
                                                        <span><label class="booking_time f-700 img-detail"></label></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div id="paypal-button-container" class="d-none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light mt-3">
                                <div class="px-sm-3">
                                    <ul class="pager wizard list-inline mb-0">
                                        <li class="previous">
                                            <button class="btn btn-link ps-0" type="button">
                                                <span class="fas fa-chevron-left me-2 prev-button"
                                                    data-fa-transform="shrink-3"></span>
                                                {{ __('Prev') }}
                                            </button>
                                        </li>
                                        <li class="next">
                                            <button class="btn btn-primary px-5 px-sm-6 next-button btn-valid" type="button"
                                                id="book-button">
                                                {{ __('Next') }}
                                                <span class="fas fa-chevron-right ms-2"
                                                    data-fa-transform="shrink-3"></span>
                                            </button>

                                            <button class="pay-payumoney d-none">Pay with PayUMoney</button> <!-- New -->

                                            <button class="btn btn-info px-5 px-sm-6 pay-razorpay d-none" type="button"
                                                >
                                                {{ __('Pay With RazorPay') }}
                                            </button>
                                            <button class="btn btn-info px-5 px-sm-6 pay-stripe d-none" type="button"
                                                >
                                                {{ __('Pay With Stripe') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stripe modal start -->
<div class="modal fade" id="stripemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="container mt-c-10 mb-c-10">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                        <div class="row text-center">      
                            <span class="countdown d-none">{{ __('Complete your payment process within') }} : <span class="timeleft"></span></span>              
                        </div>
                            <div class="card">
                                <form action="{{route('intent')}}" method="post" id="payment-form" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                    
                                        <div class="card-header">
                                            <label for="card-element">
                                                {{ __('Enter your credit card information') }}
                                            </label>
                                        </div>
                                        <div class="card-body">
                                            <div id="card-element">
                                            </div>
                                            <div id="card-errors" role="alert"></div>
                                            <input type="hidden" name="plan" value="" />
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button id="card-button" class="btn btn-dark" type="submit" data-secret=""
                                            data-appointment=""> {{ __('Pay') }} </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Stripe modal end -->
<!-- ============================================-->
@endsection
@section('script')
<script src="{{ asset('rbtheme/js/flatpickr.js') }}"></script>
<script src="{{asset('backend/js/phone.js')}}"></script>
<script src="{{ asset('rbtheme/js/appointment-config.js') }}"></script>
@if($custom->is_stripe == 1)
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('rbtheme/js/payment.js')}}"></script>
@endif
@if($custom->is_paypal == 1)
<script src="https://www.paypal.com/sdk/js?client-id={{($custom->paypal_active_mode == 1) ? $custom->paypal_live_client_id : $custom->paypal_client_id }}&components=buttons&locale=en_US"></script>
<script src="{{ asset('rbtheme/js/paypal.js')}}"></script>
@endif
@if($custom->is_razorpay == 1)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('rbtheme/js/rozarpay.js')}}"></script>
@endif

<!--payumoney--> <!-- New -->
<!-- <script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="https://example.com/logo.png"></script> -->
<script src="https://jssdk.payu.in/bolt/bolt.min.js"></script>
<script src="{{ asset('rbtheme/js/payumoney.js')}}"></script>

@endsection

