@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Create New Employee')])
    <link rel="stylesheet" href="{{asset('backend/css/tempus-dominus.min.css')}}">
@endsection
@section('content')
    <div class="mb-3 padding-space">
        <div class="container-fluid">
            <div class="row">
                <div class="employee-page offset-lg-2 offset-md-2 offset-md-2 col-md-8">
                    @if(Session::has('message'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{Session::get('message')}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="panel panel-default panel-custom">
                        <div class="panel-heading panel-custom-heading">
                            <h3 class="panel-title">{{ __('Create New Employee') }}</h3>
                        </div>
                        
                        <div class="panel-body">
                            <form action="{{ route('employees.store') }}" method="post" id="employee-frm" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="container-fluid">
                                    <div class="current-page">
                                        <div class="row">  
                                            <div class="col-md-12 col-lg-6">  
                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="first_name" class="form-label">{{ __('First Name') }}: </label>
                                                                <input type="text" class="form-control custom-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" placeholder="{{ __('Enter Your First Name') }}" name="first_name">
                                                                @error('first_name')
                                                                    <span class="error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="last_name" class="form-label">{{ __('Last Name') }}: </label>
                                                                <input type="text" class="form-control custom-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" placeholder="{{ __('Enter Your Last Name') }}" name="last_name">
                                                                @error('last_name')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">{{ __('Email') }}: </label>
                                                                <input type="email" class="form-control custom-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="{{ __('Enter Your Email') }}" name="email">
                                                                @error('email')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">{{ __('Password') }}: </label>
                                                                <input type="password" class="form-control custom-control @error('password') is-invalid @enderror" id="password" value="{{ old('password') }}" placeholder="{{ __('Enter Your Password') }}" name="password">
                                                                @error('password')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ old('country_name') }}">

                                                    <input type="hidden" name="country_code" id="dialcode" class="country_code" value="" data-country="{{ old('country_name') }}" data-number="{{old('phone')}}">
                
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label">{{ __('Phone') }}: </label><br>
                                                                <input type="tel" class="form-control custom-control country-phone-validation intlTelInput @error('phone') is-invalid @enderror" id="phone" pattern="[0-9]" value="{{ old('phone') }}" placeholder="{{ __('Enter Your Phone Number') }}" name="phone"
                                                                data-name="{{ $country->country_name }}">
                                                                @error('phone')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                                <span id="valid-msg" style="color: green;" class="d-none">✓ {{ __('Phone Number Valid') }}</span>
                                                                <span id="error-msg" style="color: #bd5252;" class="d-none"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Country') }}<span class="text-danger">*</span></label>
                                                                <select class="form-control rounded-0 selectpicker" data-wizard-validate-country="true" data-live-search="true" data-placeholder="{{ __('Select your country') }}" name="country" placeholder="Select Country" required="required" >
                                                                    <option value="">{{ __('Select your country') }}</option>
                                                                    @foreach (Helper::get_active_countries() as $key => $country)
                                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                    @endforeach
                                                                </select>                                                        
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('State') }}<span class="text-danger">*</span></label>
                                                                <select class="form-control rounded-0 selectpicker" data-wizard-validate-state="true" data-live-search="true" name="state" required="required" placeholder="Select State">
                                                                </select>                                            
                                                            </div>
                                                        </div>

                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="start_time" class="form-label">{{ __('Start Time') }}: </label>
                                                                <div class="input-group" id="datetimepickerRest2">
                                                                    <input type="text" class="form-control custom-control @error('start_time') is-invalid @enderror timeDuration" id="start_time" value="{{ old('start_time') }}" name="start_time" placeholder="HH:mm A">
                                                                    <span class="input-group-text">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                @error('start_time')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="finish_time" class="form-label">{{ __('Finish Time') }}: </label>
                                                                <div class="input-group" id="datetimepickerRest3">
                                                                    <input type="text" class="form-control custom-control @error('finish_time') is-invalid @enderror timeDuration" id="finish_time" value="{{ old('finish_time') }}" name="finish_time" placeholder="HH:mm A">
                                                                    <span class="input-group-text">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                @error('finish_time')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="rest_time" class="form-label">{{ __('Padding Time') }}: </label>
                                                                <div class='input-group' id="datetimepickerRest">
                                                                    <input type='text' class="form-control time @error('rest_time') is-invalid @enderror timeDuration" name="rest_time" value="{{ old('rest_time') }}" data-padding="{{ $custom->custom_time_slot }}"  id="rest_time" placeholder="HH:mm" autocomplete="off">
                                                                    <span class="input-group-text">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                @error('rest_time')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="break_start_time" class="form-label">{{ __('Break Start Time') }}: </label>
                                                                <div class="input-group" id="datetimepickerRest4">
                                                                    <input type="text" class="form-control custom-control @error('break_start_time') is-invalid @enderror timeDuration" id="break_start_time" value="{{ old('break_start_time') }}" name="break_start_time" placeholder="HH:mm A">
                                                                    <span class="input-group-text">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                @error('break_start_time')
                                                                    <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="break_end_time" class="form-label">{{ __('Break End Time') }}: </label>
                                                                <div class="input-group" id="datetimepickerRest5">
                                                                    <input type="text" class="form-control custom-control @error('break_end_time') is-invalid @enderror timeDuration" id="break_end_time" value="{{ old('break_end_time') }}" name="break_end_time" placeholder="HH:mm A">    
                                                                    <span class="input-group-text">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                @error('break_end_time')
                                                                <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3 emp-working-days">
                                                                <label for="days" class="form-label">{{ __('Working Days') }}: </label>
                                                                @php $days = array(__('Sunday'),__('Monday'),__('Tuesday'),__('Wednesday'),__('Thursday'),__('Friday'),__('Saturday'))@endphp
                                                                @php $workingDays = !empty($workingHour->days) ? json_decode($workingHour->days) : NULL @endphp
                                                                <li class="list-group-item cursor-pointer" required>
                                                                    {{__('All Days')}}
                                                                    <div class="material-switch pull-right">
                                                                        <input type="checkbox" data-check="days" id="checkedAll">                                         
                                                                        <label for="allDay" class="label-success"></label>
                                                                    </div>
                                                                </li>
                                                                @foreach($days as $key => $day)
                                                                <li class="list-group-item cursor-pointer" required>
                                                                    {{ $day }} 
                                                                    <div class="material-switch pull-right">
                                                                        <input name="days[]" type="checkbox" class="checkSingle" data-check="days" value="{{ $key }}" @if(is_array(old('days')) && in_array($key,old('days'))) checked @endif>                                         
                                                                        <label for="{{ $key }}" class="label-success"></label>
                                                                    </div>
                                                                </li>
                                                                @endforeach    
                                                                @error('days')
                                                                <span class=" error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <a href="{{ route('employees.index') }}" class="back-button-previous pull-left"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                                            </div>
                                            <div class="col-lg-6">
                                            <a class="next-button pull-right" id="next-button" style="cursor: pointer;"><h4>{{ __('Next') }} <i class="fa fa-arrow-right" aria-hidden="true"></i></h4></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="next-page" style="display:none;">
                                        <div class="row">
                                            @if($custom->categories == 1)
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('Categories') }}:</label>
                                                            @foreach($categories as $category)
                                                            <li class="list-group-item" required>
                                                                {{ $category->name }}
                                                                <div class="material-switch pull-right">
                                                                    <input  value="{{ $category->id }}" name="category_id[]" type="checkbox" data-check="categories" @if(is_array(old('category_id')) && in_array($category->id,old('category_id'))) checked @endif>
                                                                    <label for="{{ $category->id }}" class="label-success"></label>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                            @error('category_id')
                                                            <span class=" error-message">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else 
                                            <input value="0" name="category_id[]" type="hidden">
                                            @endif
                                            
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-check mb-3" name="service_id" id="service_id">
                                                            <label class="form-label">{{ __('Services') }}:</label>
                                                            @foreach($services as $service)
                                                            <li class="list-group-item" required>
                                                                <span class="text-wrap">
                                                                    {{ $service->name }}
                                                                </span>
                                                                <div class="material-switch pull-right">
                                                                    <input value="{{ $service->id }}" class="form-check-input" name="service_id[{{ $service->category_id }}][]" data-check="service" type="checkbox"  @if(is_array(old('service_id')) && isset(old('service_id')[$service->category_id]) && in_array($service->id ,old('service_id')[$service->category_id])) checked @endif>
                                                                    <label for="{{ $service->id }}" class="form-check-label label-success"></label>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        </div>
                                                        @error('service_id')
                                                        <span class=" error-message">{{ $message }}</span>
                                                        @enderror 
                                                    </div>
                                                </div>
                                            </div> 

                                        </div>
                                        
                                        {{-- <div class="row">
                                            <div class="col-lg-12">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        test
                                                        </button>
                                                    </h5>
                                                    </div>

                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                    <div class="card-body">
                                                        Anim pariatur 
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        
                                        <div class="row">
                                            <div class="offset-sm-6 col-sm-2 col-xs-offset-2 col-xs-8">
                                                <button type="submit" class="btn btn-default custom-btn btn-block btn-valid">{{ __('Submit') }}</button>
                                            </div>
                                        </div>
                                        <a class="back-button-next pull-left" style="cursor: pointer;"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('backend/js/tempus-dominus.min.js') }}"></script>
<script src="{{asset('backend/js/datetimepicker-config.js')}}"></script>
<script src="{{asset('backend/js/employee.js')}}"></script>
<script src="{{asset('backend/js/phone.js')}}"></script>
@endsection
