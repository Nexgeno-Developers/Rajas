@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Payment Setting')])
@endsection
@section('content')
<div class="mt-1">
    <div class="light-style flex-grow-1 container-p-y container-padding">
        @include('includes.message-block')
        <h3 class="font-weight-bold t-center">
            {{ __('Payment Method Settings') }}
        </h3>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="StripeForm" autocomplete="off">
                        @csrf
                        <div class="card-body pb-2">
                            <img src="{{ asset('rbtheme/img/stripe-logo.png') }}" class="" height="40px" width="100px" alt="{{ __('Smtp logo') }}">
                            <hr class="border-light m-0">
                            
                            <div class="mb-3 status-mode">
                                <label for="stripe" class="form-label va-bottom">{{ __('Status') }}:</label>  
                                <input type="checkbox" class="toggle-set" id="stripe" name="is_stripe" value="1" data-toggle="toggle" data-style="slow"
                                data-onstyle="success" data-offstyle="danger" data-off="{{ __('Inactive') }}"  data-on="{{ __('Active') }}"
                                {{ ($smtp->is_stripe == 1) ? "checked": "" }}>
                                
                            </div>
                            
                            <div class="mb-3 pull-lg-right ">
                                <label for="stripe" class="form-label va-bottom">{{ __('Mode') }}:</label>  
                                <input type="checkbox" class="toggle-set" id="stripe" name="stripe_active_mode" value="1" data-toggle="toggle" data-style="slow"
                                data-onstyle="success" data-offstyle="primary" data-off="{{ __('Sandbox') }}"  data-on="{{ __('Live') }}"
                                {{ ($smtp->stripe_active_mode == 1) ? "checked": "" }}>
                            </div>
                            
                            <div class="mt"><label for="test" class="form-label"> {{ __('SandBox Credentials') }}</label></div>
                            <div class="mb-3">
                                <label for="Key" class="form-label">{{ __('Stripe Key') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->stripe_key }}" name="stripe_key" placeholder="{{ __('Stripe Key') }}"> 
                            </div>
                            <div class="mb-3">
                                <label for="Secret" class="form-label">{{ __('Stripe Secret') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->stripe_secret }}" name="stripe_secret" placeholder="{{ __('Stripe Secret') }}"> 
                            </div>
                            <hr class="border-light m-0">
                            <label for="live" class="form-label"> {{ __('Live Credentials') }}</label>
                            <div class="mb-3">
                                <label for="Key" class="form-label">{{ __('Stripe Key') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->stripe_live_key }}" name="stripe_live_key" placeholder="{{ __('Stripe Key') }}"> 
                            </div>
                            <div class="mb-3">
                                <label for="Secret" class="form-label">{{ __('Stripe Secret') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->stripe_secret_live }}" name="stripe_secret_live" placeholder="{{ __('Stripe Secret') }}"> 
                            </div>
                            <div class="text-right mt-5 mb-5">
                                <button type="button" class="btn btn-primary stripeSubmit">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="paypalForm" autocomplete="off">
                        @csrf
                        <div class="card-body pb-2">

                            <img src="{{ asset('rbtheme/img/PayPal.png') }}" class="" height="35px" width="120px" alt="{{ __('Smtp logo') }}">
                            <hr class="border-light m-0">
                            @if($smtp->currency == "INR")
                            <div>
                                <span class="text-danger">{{ __('Currency INR not Supported in PayPal. Please refer the supported currency in PayPal') }} *</span>
                            </div>
                            @endif
                            <div class="mb-3 status-mode">
                                <label for="paypal" class="form-label va-bottom">{{ __('Status') }}:</label>  
                                <input type="checkbox" class="toggle-set" id="paypal" name="is_paypal" value="1" data-toggle="toggle" data-style="slow"
                                data-onstyle="success" data-offstyle="danger" data-off="{{ __('Inactive') }}"  data-on="{{ __('Active') }}"
                                {{ ($smtp->currency == "INR") ? "disabled" : (($smtp->is_paypal == 1) ? "checked": "") }}>
                            </div>
                            <div class="mb-3 pull-lg-right ">
                                    <label for="stripe" class="form-label va-bottom">{{ __('Mode') }}:</label>  
                                    <input type="checkbox" class="toggle-set" id="paypal" name="paypal_active_mode" value="1" data-toggle="toggle" data-style="slow"
                                    data-onstyle="success" data-offstyle="primary" data-off="{{ __('Sandbox') }}"  data-on="{{ __('Live') }}"
                                    {{ ($smtp->currency == "INR") ? "disabled" : (($smtp->paypal_active_mode == 1) ? "checked": "") }}>
                                </div>
                                
                                <div class="mt"><label for="test">{{ __('SandBox Credentials') }}</label></div>
                                <div class="mb-3">
                                <label for="currency" class="form-label">{{ __('Paypal Key') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->paypal_client_id }}" name="paypal_client_id" placeholder="{{ __('Paypal Client ID') }}" @if($smtp->currency == "INR") disabled @endif> 
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-label">{{ __('Paypal Secret') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->paypal_client_secret }}" name="paypal_client_secret" placeholder="{{ __('Paypal Client Secret') }}" @if($smtp->currency == "INR") disabled @endif> 
                            </div> 
                            <div class="mb-3">
                                <label for="currency" class="form-label">{{ __('Paypal Locale') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->paypal_locale }}" name="paypal_locale" placeholder="{{ __('Paypal Locale') }}" @if($smtp->currency == "INR") disabled @endif> 
                            </div>
                            
                            <hr class="border-light m-0">
                            <label for="live" class="form-label"> {{ __('Live Credentials') }}</label>
                            <div class="mb-3">
                                <label for="currency" class="form-label">{{ __('Paypal Key') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->paypal_live_client_id }}" name="paypal_live_client_id" placeholder="{{ __('Paypal Client ID') }}" @if($smtp->currency == "INR") disabled @endif> 
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-label">{{ __('Paypal Secret') }}:</label>
                                <input type="text" class="form-control" value="{{ $smtp->paypal_client_secret_live }}" name="paypal_client_secret_live" placeholder="{{ __('Paypal Client Secret') }}" @if($smtp->currency == "INR") disabled @endif> 
                            </div> 
                            <div class="text-right">
                                <button type="button" class="btn btn-primary paypalSubmit" @if($smtp->currency == "INR") disabled @endif>{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="razorpayForm" autocomplete="off">
                    @csrf
                    <div class="card-body pb-2">

                        <img src="{{ asset('rbtheme/img/razorpay.webp') }}" class="" height="50px" width="150px" alt="{{ __('Smtp logo') }}">
                        <hr class="border-light m-0">
                        <div class="mb-3 status-mode">
                            <label for="razorpay" class="form-label va-bottom">{{ __('Status') }}:</label>  
                            <input type="checkbox" class="toggle-set" id="paypal" name="is_razorpay" value="1" data-toggle="toggle" data-style="slow"
                            data-onstyle="success" data-offstyle="danger" data-off="Inactive"  data-on="{{ __('Active') }}"
                            {{ ($smtp->is_razorpay == 1) ? "checked": "" }}>
                        </div>
                        <div class="mb-3 pull-lg-right ">
                            <label for="razorpay" class="form-label va-bottom">{{ __('Mode') }}:</label>  
                            <input type="checkbox" class="toggle-set" id="razorpay" name="razorpay_active_mode" value="1" data-toggle="toggle" data-style="slow"
                            data-onstyle="success" data-offstyle="primary" data-off="{{ __('Sandbox') }}"  data-on="{{ __('Live') }}"
                            {{ ($smtp->razorpay_active_mode == 1) ? "checked": "" }}>
                        </div>
                        
                        <div class="mt"><label for="test" > {{ __('SandBox Credentials') }}</label></div>
                        <div class="mb-3">
                            <label for="key_id" class="form-label"> {{ __('Key Id') }}</label>
                            <input type="text" class="form-control" name="razorpay_test_key" value="{{ $smtp->razorpay_test_key }}" placeholder="{{ __('Razorpay Test Key') }}">
                        </div>
                        <div class="mb-3">
                            <label for="key_secret" class="form-label"> {{ __('Key Secret') }}</label>
                            <input type="text" class="form-control" name="razorpay_test_secret" value="{{ $smtp->razorpay_test_secret }}" placeholder="{{ __('Razorpay Test Secret') }}">
                        </div>
                        
                        <hr class="border-light m-0">
                        <label for="live" class="form-label"> {{ __('Live Credentials') }}</label>
                        <div class="mb-3">
                            <label for="key_id" class="form-label"> {{ __('Key Id') }}</label>
                            <input type="text" class="form-control" name="razorpay_live_key" value="{{ $smtp->razorpay_live_key }}" placeholder="{{ __('Razorpay Live Key') }}">
                        </div>
                        <div class="mb-3">
                            <label for="key_secret" class="form-label"> {{ __('Key Secret') }}</label>
                            <input type="text" class="form-control" name="razorpay_live_secret" value="{{ $smtp->razorpay_live_secret }}" placeholder="{{ __('Razorpay Live Secret') }}">
                        </div>
                        <div class="text-right mt-5 mb-5">
                                <button type="button" class="btn btn-primary razorPaySubmit">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection