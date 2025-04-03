@extends('layouts.app')
@section('head')
    @include('includes.head', ['title' => trans('Notification Setting')])
@endsection

@section('content')
    <div class="mt-3">
        <div class="light-style flex-grow-1 container-p-y container-padding">
            @if(Session::has('message'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            {{Session::get('message')}}
                        </div>
                    </div>
                </div>
            @endif

            @if(Session::has('error-message'))
                <div class="row list-of-all-errors">
                    <div class="col-md-12 error">
                        <div class="alert alert-danger errors">
                            {{Session::get('error-message')}}
                        </div>
                    </div>
                </div>
            @endif
            <h3 class="font-weight-bold t-center">
            {{ __('Notification Setting') }}
            </h3>
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <div class="card row-bordered card-setting">
                        <form action="{{ route('sms.notification.update' )}}" method="post" id="notification-frm" autocomplete="off">
                            @csrf
                            <h4 class="font-weight-bold mb-4">
                                {{ __('SMS Notification') }}
                            </h4>
                            <img src="{{ asset('rbtheme/img/smtp-logo.png') }}" class="img-right" height="40px" width="40px" alt="{{ __('SMS Image') }}">
                            <hr class="border-light mt-0" size="4">
                         
                            <div class="mb-3 status-mode">
                                <label for="mail" class="form-label">{{ __('Status') }}:</label>
                                <input type="checkbox"  id="sms-notification" name="notification" value="1" data-toggle="toggle" data-style="slow"
                                data-onstyle="success" data-offstyle="danger" data-off="{{ __('Inactive') }}"  data-on="{{ __('Active') }}"
                                {{ ($smtp->notification == 1) ? "checked": "" }}> 
                            </div>   
                           
                            <div class="mb-3 pull-lg-right">
                                <label for="twilio" class="form-label va-bottom">{{ __('Mode') }}:</label>  
                                <input type="checkbox" class="toggle-set" id="twilio" name="twilio_active_mode" value="1" data-toggle="toggle" data-style="slow"
                                data-onstyle="success" data-offstyle="primary" data-off="{{ __('Sandbox') }}"  data-on="{{ __('Live') }}"
                                {{ ($smtp->twilio_active_mode == 1) ? "checked": "" }}>
                            </div>
                           
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mt-3">
                                        <label for="">{{ __('Sent Notification To') }} :</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="twilio_notify_customer" id="twilio-notify-customer" value="1" {{ ($smtp->twilio_notify_customer == 1) ? "checked": "" }}>
                                                <label class="form-check-label" for="twilio-notify-customer">{{ __('Customer') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="twilio_notify_employee" id="twilio-notify-employee" value="1" {{ ($smtp->twilio_notify_employee == 1) ? "checked": "" }}>
                                                <label class="form-check-label" for="twilio-notify-employee">{{ __('Employee') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="twilio_notify_admin" id="twilio-notify-admin" value="1" {{ ($smtp->twilio_notify_admin == 1) ? "checked": "" }}>
                                                <label class="form-check-label" for="twilio-notify-admin">{{ __('Admin') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3" id="notification-error">
                                    </div>
                                
                                    <div class="mt-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="use_twilio_service_id" id="use-twilio-service-id" value="1" {{ ($smtp->use_twilio_service_id == 1) ? "checked": "" }}>
                                            <label class="form-check-label" for="use-twilio-service-id">{{ __('Send Notification Using Messaging Service Id') }}</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <label for="twilio-service-id" class="form-label">{{ __('Messaging Service Id') }}</label>
                                        <input type="text" class="form-control" name="twilio_service_id" id="twilio-service-id" value="{{ $smtp->twilio_service_id }}" placeholder="{{ __('Messages Service Id') }}">
                                        @error('twilio_service_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    {{-- <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ $smtp->country_name }}">

                                    <input type="hidden" name="country_code" id="dialcode" class="country_code" value="{{ $smtp->country_code }}" data-country="{{ $smtp->country_name }}" data-number="{{ $smtp->twilio_phone }}"> --}}

                                    <div class="mt-3">
                                        <label for="twilio-live-phone-number" class="form-label">{{ __('Send Message From') }}</label>
                                        <small>({{ __('Twilio Registered Phone Number') }})</small>
                                        <input type="tel" class="form-control twilioLivePhone" name="twilio_phone" id="twilio-phone-number" value="{{ $smtp->twilio_phone }}" placeholder="{{ __('Twilio Phone Number') }}">
                                        @error('twilio_phone')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="col-lg-6">
                                    <label class="font-weight-bold" for="sandbox_credentials">{{ __('SandBox Credentials') }}</label>
                                    <hr class="border-light mt-0" size="4">
                                    <div class="mb-3">
                                        <label for="twilio-key" class="form-label">{{ __('Twilio Key') }}</label>
                                        <input type="text" class="form-control" name="twilio_sandbox_key" id="twilio-key" value="{{ $smtp->twilio_sandbox_key }}" placeholder="{{ __('Twilio Account SID') }}">
                                        @error('twilio_sandbox_key')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="twilio-secret" class="form-label">{{ __('Twilio Secret') }}</label>
                                        <input type="text" class="form-control" name="twilio_sandbox_secret" id="twilio-secret" value="{{ $smtp->twilio_sandbox_secret }}" placeholder="{{ __('Twilio Auth Token') }}">
                                        @error('twilio_sandbox_secret')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                
                                    <label class="mt-3 font-weight-bold" for="live_credentials">{{ __('Live Credentials') }}</label>
                                    <hr class="border-light mt-0" size="4">
                                    <div class="mb-3">
                                        <label for="twilio-live-key" class="form-label">{{ __('Twilio Key') }}</label>
                                        <input type="text" class="form-control" name="twilio_live_key" id="twilio-live-key" value="{{ $smtp->twilio_live_key }}" placeholder="{{ __('Twilio Account SID') }}">
                                        @error('twilio_live_key')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="twilio-live-secret" class="form-label">{{ __('Twilio Secret') }}</label>
                                        <input type="text" class="form-control" name="twilio_live_secret" id="twilio-live-secret" value="{{ $smtp->twilio_live_secret }}" placeholder="{{ __('Twilio Auth Token') }}">
                                        @error('twilio_live_secret')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                          
                                <div class="row save">
                                    
                                    <div class="col ">
                                        {{-- <span class="pull-right"> --}}
                                            <button type="button" class="btn btn-secondary float-right-c testSms" data-bs-toggle="modal" data-bs-target="#testSmsModel">
                                                    {{ __('Test SMS Notification')}}
                                            </button>
                                        {{--</span> --}}
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary  btn-valid">{{ __('Update') }}</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="testSmsModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="testSmsModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="checkSms" action="javascript:;" class="w-100" method="POST" autocomplete="off">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Checking SMS Configuration')}}</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                </div>

                <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ old('country_name') }}">

                <input type="hidden" name="country_code" id="dialcode" class="country_code" value="{{ old('country_code') }}" data-country="{{ old('country_name') }}" data-number="{{old('phone')}}">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="phone" class="col-form-label">{{ __('Phone:') }} <span class="error">*</span></label>
                        <input type="tel" class="form-control country-phone-validation" name="phone" placeholder="{{__('Enter Phone Number')}}" value="" data-name="{{ $country->country_name }}" required>
                        <label id="valid-msg" style="color: green;" class="d-none phone-valid-msg">✓ {{ __('Phone Number Valid') }}</label>
                        <label id="error-msg" style="color: #bd5252;" class="d-none phone-error-msg"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary verifySms">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>          
@endsection
@section('scripts')
<script src="{{asset('backend/js/phone.js')}}"></script>
@endsection