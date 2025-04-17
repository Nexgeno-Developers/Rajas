@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Create Appointment')])
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('rbtheme/css/booking-slots.css')}}">
<link href="{{ asset('rbtheme/css/loader.css') }}" rel="stylesheet" id="style-default">
@endsection
@section('content')
    <div class="mb-3 padding-space">
        <div class="container-fluid">
            <div class="row container-of-success d-none">
                <div class="col-md-12 error">
                    <div class="alert alert-success">
                        <ul class="list-of-success">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="panel panel-default panel-custom">
                        <div class="panel-heading panel-custom-heading">
                            <h3 class="panel-title">{{ __('Create New Appointment') }}</h3>
                        </div>
                        <div class="panel-body">
                            <form action="javascript:;" method="post" id="formdata">
                                {{ csrf_field() }}
                                <div class="container-fluid">
                                   @if($custom->categories == 1)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label>{{ucfirst($custom->custom_field_category)}}:</label>
                                                <select name="category_id" id="category_id" class="form-control custom-control" required>
                                                    <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_category)}}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->name }}" data-id="{{$category->id}}" {{ ($category->id == old('category_id')) ? 'selected' : '' }}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class=" error-message" id="err-category_id"></span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
        
                                    {{-- @if($custom->categories != 1)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="service_id">{{ucfirst($custom->custom_field_service)}}: </label>
                                                <select name="service_id" id="service_id" class="form-control custom-control" required>
                                                    <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_service)}}</option>
                                                   
                                                        @foreach($services as $service)
                                                            <option value="{{ $service->name }}" data-id="{{$service->id}}" data-max-weight="{{$service->allowed_weight}}" data-max-person="{{$service->no_of_person_allowed}}" {{ ($service->id == old('service_id')) ? 'selected' : '' }}>
                                                                {{$service->name}}
                                                                {{!empty($service->categories) ? '('.$service->categories->name.')' : ''}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class=" error-message" id="err-category_id"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif --}}
        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="service_id" class="form-label">{{ucfirst($custom->custom_field_service)}}: </label>
                                                    <select name="service_id" id="service_id" class="form-control custom-control" data-check="service" required>
                                                        <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_service)}}</option>
                                                        @if($custom->categories != 1)
                                                            @foreach($services as $service)
                                                                <option value="{{ $service->name }}" data-id="{{$service->id}}" {{ ($service->id == old('service_id')) ? 'selected' : '' }}>
                                                                    {{$service->name}}
                                                                    {{!empty($service->categories) ? '('.$service->categories->name.')' : ''}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <span class=" error-message" id="err-service_id"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($custom->employees == 1)
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="employee_id" class="form-label previous-serviceid" data-previous-serviceid="{{ old('employee_id') }}" data-customFieldText="{{ ucfirst($custom->custom_field_text) }}">{{ucfirst($custom->custom_field_text)}}: </label>
                                                    <select name="employee_id" id="employee_id" class="form-control custom-control">
                                                           <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_text)}}</option>     
                                                    </select>
                                                    <span class=" error-message" id="err-employee_id"></span>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif($custom->employees == 0)
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                                        @endif
                                        
                                        @if(Auth::user()->role_id == 1)
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="customer" class="form-label">{{ __('Customer') }}: </label>
                                                        <select name="user_id" id="customer_id" class="form-control custom-control">
                                                            <option value="">{{ __('Select Customer') }}</option>
                                                            @foreach($customers as $customer)
                                                                <option value="{{ $customer->id }}">{{$customer->first_name.' '.$customer->last_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class=" error-message" id="err-user_id"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="admin_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                                            {{-- <input type="hidden" class="form-control custom-control" name="user_id" id="customer_id" value="{{Auth::user()->id}}"> --}}
                                            @elseif(Auth::user()->role_id == 2)
                                            <input type="hidden" name="admin_id" value="{{ \Illuminate\Support\Facades\Auth::user()->parent_user_id }}">                              
                                            <input type="hidden" class="form-control custom-control" name="user_id" id="customer_id" value="{{Auth::user()->id}}">
                                                
                                        @endif

                                        <!-- New fileds -->
                                        <div class="row g-2">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Number of Person') }}<span class="text-danger">*</span></label>
                                                <input autocomplete="off" step="1" min="1" max="20" class="form-control" type="number" name="no_of_person_allowed" placeholder="{{ __('Enter Number of Person') }}"
                                                    data-wizard-validate-allowed-person="true" id="bootstrap-wizard-allowed-person" required />
                                                <div class="invalid-feedback">{{ __('Please enter the number of person') }}</div>                                    
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Total Weight') }}<span class="text-danger">*</span></label>                                            
                                                <input autocomplete="off" step="1" min="1" max="10" class="form-control" type="number" name="allowed_weight" placeholder="{{ __('Enter Weight') }}"
                                                    data-wizard-validate-allowed-weight="true" id="bootstrap-wizard-allowed-weight" required />
                                                <div class="invalid-feedback">{{ __('Please enter the weight') }}</div>                                             
                                            </div>
                                        </div>
                                    </div>                                        
        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">{{ __('Date') }}: </label>
                                                    <input type="text" class="form-control custom-control custom-format" id="adate" min="{{date('Y-m-d')}}"
                                                    value="{{old('date')}}" name="date" data-wizard-validate-date="true" data-date-format="{{ $custom->date_format }}" placeholder="{{ __('Please Select Date') }}">
                                                    <span class=" error-message" id="err-date"></span>
                                                </div>
                                            </div>
                                        </div>
        
                                        <label for="time" class="form-label">{{ __('Appointment Time') }}: </label>
                                        <div id="msg" ></div>
                                        <span class=" error-message" id="err-slots"></span>
                                                   
                                        <input type="hidden" name="slots" id="time" value="">
        
                                        <div class="col-lg-12 mt-3">
                                            <div class="bookly-time-step">
                                                <div class="bookly-columnizer-wrap">
                                                    <div class="bookly-columnizer">
                                                        <div class="bookly-time-screen">
                                                            <div class="bookly-column bookly-js-first-column">
                                                                <div class="row" id="time-slots">
                                                                    <div class="col-md-12">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="comments">{{ __('Comment') }}: </label>
                                                    <textarea class="form-control custom-control d-resize" id="comments" value="{{old('comments')}}" name="comments" 
                                                    placeholder="{{ __('Enter Comments') }}" maxlength="150">{{old('comments')}}</textarea>
                                                    <span class=" error-message" id="err-comments"></span>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <hr>
            
                                        <div class="row">
                                            <div class="offset-sm-4 col-sm-4 col-xs-offset-2 col-xs-8">
                                                <button type="button" id="submit" class="btn btn-default custom-btn btn-block">{{ __('Submit') }}</button>
                                            </div>
                                        </div>
                                        <a href="{{ route('appointments.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                                    </div>
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
<script src="{{asset('backend/js/appointment.js')}}"></script>
@endsection
