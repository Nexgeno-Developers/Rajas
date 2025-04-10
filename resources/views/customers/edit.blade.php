@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Edit Customer')])
@endsection
@section('content')
<div class="mb-3 padding-space">
    <div class="container-fluid">
        <div class="row">
            @if(Session::has('message'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            {{Session::get('message')}}
                        </div>
                    </div>
                </div>
            @endif
            <div class="offset-lg-3 offset-md-3 col-md-6">
                <div class="panel panel-default panel-custom">
                    <div class="panel-heading panel-custom-heading">
                        <h3 class="panel-title">{{ __('Edit Customer') }} : {{ $customers->first_name }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <form method="POST" action="{{ route('customers.update',$customers->id)}}" id="customerDetail" autocomplete="off">
                                @method('PATCH')
                                {{ csrf_field() }}
                                <div class="row">  
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label">{{ __('First Name') }}: </label>
                                                    <input type="text" class="form-control custom-control @error('first_name') is-invalid @enderror" id="first_name" value="{{$customers->first_name}}" name="first_name">
                                                </div>
                                            </div>
                                    
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label">{{ __('Last Name') }}: </label>
                                                    <input type="text" class="form-control custom-control @error('last_name') is-invalid @enderror" id="last_name" value="{{$customers->last_name}}" name="last_name" required>
                                                        @error('last_name')
                                                            <span class=" error-message">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">{{ __('Email') }}: </label>
                                                    <input type="email" class="form-control custom-control @error('email') is-invalid @enderror" id="email" value="{{$customers->email}}" name="email">
                                                        @error('email')
                                                            <span class=" error-message">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                            </div>
                                        
                                            <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ $customers->country_name }}">

                                            <input type="hidden" name="country_code" class="country_code" id="dialcode" value="{{ $customers->country_code }}" data-country="{{ $customers->country_name }}"  data-number="{{ $customers->phone }}">

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">{{ __('Phone') }}: </label>
                                                    <input type="tel" class="form-control custom-control intlTelInput country-phone-validation @error('phone') is-invalid @enderror" id="phone" value=""
                                                     name="phone" data-name="{{ $customers->country_name }}">
                                                        @error('phone')
                                                            <span class=" error-message">{{ $message }}</span>
                                                        @enderror
                                                        <span id="valid-msg" style="color: green;" class="d-none">✓ {{ __('Phone Number Valid') }}</span>
                                                        <span id="error-msg" style="color: #bd5252;" class="d-none"></span>
                                                </div>
                                            </div>


                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Country') }}<span class="text-danger">*</span></label>
                                                    <select class="form-control rounded-0 selectpicker" data-wizard-validate-country="true" data-live-search="true" data-placeholder="{{ __('Select your country') }}" name="country" placeholder="Select Country" required="required" >
                                                        <option value="">{{ __('Select your country') }}</option>
                                                        @foreach (Helper::get_active_countries() as $key => $country)
                                                        <option value="{{ $country->id }}" @auth @if($customers->country == $country->id) selected @endif @endauth>{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>                                                        
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('State') }}<span class="text-danger">*</span></label>
                                                    <select class="form-control rounded-0 selectpicker" data-wizard-validate-state="true" data-live-search="true" name="state" required="required" placeholder="Select State">

                                                    </select>                                            
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-none">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bootstrap-wizard-wizard-email ">{{ __('City') }}</label>
                                                    <input class="form-control" type="text" name="city"  value="{{$customers->city}}" placeholder="{{ __('Enter City') }}" data-wizard-validate-city="true" id="bootstrap-wizard-city" />
                                                    <div class="invalid-feedback">{{ __('Please enter the city name') }}</div>                                    
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-none">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Zipcode') }}</label>                                            
                                                    <input class="form-control" type="text" name="zipcode" value="{{$customers->zipcode}}" placeholder="{{ __('Enter Zipcode') }}" data-wizard-validate-zipcode="true" id="bootstrap-zipcode" />
                                                    <div class="invalid-feedback">{{ __('Please enter the zipcode') }}</div>                                             
                                                </div>
                                            </div>     
                                            
                                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Goverment ID Number') }} <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="goverment_id" value="{{$customers->goverment_id}}" placeholder="{{ __('Enter Goverment ID Number') }}"
                                                        data-wizard-validate-goverment-id="true" id="bootstrap-wizard-goverment-id" required />
                                                    <div class="invalid-feedback">{{ __('Please enter the Goverment ID Number') }}</div>                                    
                                                </div>
                                            </div> 


                                        </div>
                                    </div>   
                                </div>
                                <hr>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-default custom-btn btn-block btn-valid">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                                <a href="{{ route('customers.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('backend/js/phone.js')}}"></script>
<script>
    $(document).ready(function () {
        setTimeout(function() {
            var state = '{{$customers->state}}';
            $('[name="state"]').val(state);
            $('[name="state"]').selectpicker('refresh');
        }, 1000);
    });
</script>
@endsection

