@extends('layouts.app')
@section('head')
@include('includes.head',['title'=> trans('Edit Employee')])
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
                        <h3 class="panel-title">{{ ucfirst($employee->first_name).' '. ucfirst($employee->last_name) }}</h3>
                    </div>
                    <div class="panel-body">
                        @if(!empty($workingHour))
                        {{  Form::model($employee, ['method' => 'PATCH','id' => 'employeeForm', 'route' => ['employees.update', $employee->id]])  }}
                        @else
                        {{ Form::model($employee, ['method' => 'POST', 'id' => 'employeeForm', 'route' => ['completeRegister']]) }}
                        <input type="hidden" name="employee_id" value="{{ isset($employee) ? $employee->id : auth()->user()->id }}">
                        <input type="hidden" name="parent_user_id" value="{{ isset($employee) ? $employee->parent_user_id : auth()->user()->parent_user_id }}">
                        <input type="hidden" name="user_id" value="{{ isset($employee) ? $employee->parent_user_id : auth()->user()->parent_user_id }}">
                        @endif
                        {{ csrf_field() }}
                       
                        <div class="container-fluid">
                            <div class="current-page">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control custom-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ $employee->first_name }}" placeholder="{{ __('Enter Your First Name') }}" name="first_name">
                                                    @error('first_name')
                                                        <span class=" error-message">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control custom-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ $employee->last_name }}" placeholder="{{ __('Enter Your Last Name') }}" name="last_name">
                                                    @error('last_name')
                                                        <span class=" error-message">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                                    <input readonly type="text" class="form-control custom-control @error('email') is-invalid @enderror" id="email" value="{{ $employee->email }}" placeholder="{{ __('Enter Your Email') }}" name="email">
                                                    @error('email')
                                                        <span class=" error-message">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ $employee->country_name }}">

                                        <input type="hidden" name="country_code" class="country_code" id="dialcode" value="{{ $employee->country_code }}" data-country="{{ $employee->country_name }}"  data-number="{{ $employee->phone }}">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">{{ __('Phone') }} <span class="text-danger">*</span></label><br>
                                                    <input type="tel" class="form-control custom-control country-phone-validation intlTelInput @error('phone') is-invalid @enderror" id="phone" value="" 
                                                    data-name="{{ $employee->country_name }}" name="phone">
                                                    {{-- placeholder="{{ __('Enter Your Phone') }}" --}}
                                                    @error('phone')
                                                        <span class="error-message">{{ $message }}</span>
                                                    @enderror
                                                    <span id="valid-msg" style="color: green;" class="d-none phone-valid-msg">✓ {{ __('Phone Number Valid') }}</span>
                                                    <span id="error-msg" style="color: #bd5252;" class="d-none phone-error-msg"></span>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="bootstrap-wizard-wizard-email">{{ __('Country') }}<span class="text-danger">*</span></label>
                                                    <select class="form-control rounded-0 selectpicker" data-wizard-validate-country="true" data-live-search="true" data-placeholder="{{ __('Select your country') }}" name="country" placeholder="Select Country" required="required" >
                                                        <option value="">{{ __('Select your country') }}</option>
                                                        @foreach (Helper::get_active_countries() as $key => $country)
                                                        <option value="{{ $country->id }}" @if($country->id == $employee->country) selected @endif>{{ $country->name }}</option>
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
                                                    <label for="start_time" class="form-label">{{ __('Start Time') }} <span class="text-danger">*</span></label>
                                                    <div class="input-group" id="datetimepickerRest2">
                                                        <input type="text" class="form-control custom-control @error('start_time') is-invalid @enderror timeDuration" id="start_time"
                                                            value="{{ !empty($workingHour) ? date('Y-m-d h:i A',strtotime($workingHour->start_time)) : '' }}" name="start_time" placeholder="HH:mm A">
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
                                                    <label for="finish_time" class="form-label">{{ __('Finish Time') }} <span class="text-danger">*</span></label>
                                                    <div class="input-group" id="datetimepickerRest3">
                                                        <input type="text" class="form-control custom-control @error('finish_time') is-invalid @enderror timeDuration" id="finish_time"
                                                        value="{{ !empty($workingHour) ? date('Y-m-d h:i A',strtotime($workingHour->finish_time)) : '' }}" name="finish_time" placeholder="HH:mm A">
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
                                                    <label for="rest_time" class="form-label">{{ __('Padding Time') }} @if($custom->custom_time_slot != 0)<span class="text-danger">*</span>@endif</label>
                                                    <div class='input-group' id="datetimepickerRest">
                                                        <input type='text' class="form-control @error('rest_time') is-invalid @enderror timeDuration" name="rest_time" id="rest_time" data-padding="{{ $custom->custom_time_slot }}" value="{{ (!empty($workingHour) && !empty($workingHour->rest_time)) ? date('Y-m-d H:i', strtotime($workingHour->rest_time)) : '' }}" placeholder="HH:mm">
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
                                                    <label for="break_start_time" class="form-label">{{ __('Break Start Time') }} </label>
                                                    <div class="input-group" id="datetimepickerRest4">
                                                        <input type="text" class="form-control custom-control @error('break_start_time') is-invalid @enderror timeDuration" id="break_start_time"
                                                            value="{{ (!empty($workingHour) && !empty($workingHour->break_start_time)) ? date('Y-m-d h:i A',strtotime($workingHour->break_start_time)) : '' }}" name="break_start_time" placeholder="HH:mm A">
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
                                                    <label for="break_end_time" class="form-label">{{ __('Break End Time') }} </label>
                                                    <div class="input-group" id="datetimepickerRest5">
                                                        <input type="text" class="form-control custom-control @error('break_end_time') is-invalid @enderror timeDuration" id="break_end_time"
                                                            value="{{ (!empty($workingHour) && !empty($workingHour->break_end_time)) ? date('Y-m-d h:i A',strtotime($workingHour->break_end_time)) : '' }}" name="break_end_time" placeholder="HH:mm A">
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
                                                    <label for="break_end_time" class="form-label">{{ __('Working Days') }} <span class="text-danger">*</span></label>
                                                    @php $days = array(__('Sunday'),__('Monday'),__('Tuesday'),__('Wednesday'),__('Thursday'),__('Friday'),__('Saturday'))@endphp
                                                    @php $workingDays = (!empty($workingHour) && !empty($workingHour->days)) ? json_decode($workingHour->days) : NULL @endphp
                                                    <li class="list-group-item cursor-pointer" required>
                                                        {{__('All Days')}}
                                                        <div class="material-switch pull-right">
                                                            <input type="checkbox" data-check="days" id="checkedAll">                                         
                                                            <label for="allDay" class="label-success"></label>
                                                        </div>
                                                    </li>
                                                    @foreach($days as $key => $day)
                                                        <li class="list-group-item" required>
                                                            {{ $day }}
                                                            <div class="material-switch pull-right">
                                                                <input value="{{ $key }}" name="days[]" class="checkSingle" data-check="days" type="checkbox" 
                                                                @if(!empty($workingDays)) @if(in_array($key, $workingDays)) {{"checked"}} @endif @endif>
                                                                <label for="{{ $key }}" class="label-success"></label>
                                                            </div>
                                                        </li>
                                                    @endforeach    
                                                    @error('working_day')
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
                                                    <label class="form-label customCategory" data-customcategory="{{ $custom->categories }}">{{ __('Categories') }} <span class="text-danger">*</span></label>
                                                    @foreach($categories as $cat)
                                                    <li class="list-group-item" required> 
                                                        {{ $cat->name }}
                                                        <div class="material-switch pull-right">
                                                            <input value="{{ $cat->id }}" name="category_id[]" data-check="edit-categories" type="checkbox" 
                                                            @foreach ($employeeServices as $categoryservice)
                                                            {{ ($categoryservice->category_id == $cat->id) ? 'checked' : "" }}  @endforeach />
                                                            <label for="{{ $cat->id }}" class="label-success"></label>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </div>
                                                @error('category_id')
                                                    <span class=" error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @else 
                                        <input value="0" name="category_id[]" type="hidden">
                                    @endif
                            
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3" name="service_id" id="service_id">
                                                    <label class="form-label servicesList" data-services='{{ json_encode($employeeServices) }}'>{{ __('Services') }} <span class="text-danger">*</span></label>
                                                    @foreach($services as $service)
                                                    <li class="list-group-item" required>
                                                        {{ $service->name }}
                                                        <div class="material-switch pull-right">
                                                            <input value="{{ $service->id }}" name="service_id[{{ $service->category_id }}][]" data-check="service" type="checkbox"   @foreach($employeeServices as $categoryservice) @if($service->id == $categoryservice->service_id) checked @endif @endforeach>
                                                            <label for="{{ $service->id }}" class="label-success"></label>
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
                                    {{  Form::close()  }}
                                </div>
                                
                                <div class="row">
                                    <div class="offset-sm-6 col-sm-2 col-xs-offset-2 col-xs-8">
                                        <button type="submit" class="btn btn-default custom-btn btn-block btn-valid">{{ __('Submit') }}</button>
                                    </div>
                                </div> 
                                <a class="back-button-next btn-valid pull-left"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a> 
                                
                                {{  Form::open(['method' => 'DELETE','id' => 'deleteItem','route' => ['employees.destroy', $employee->id],'style'=>'display:inline'])  }}
                                {{  Form::close()  }}
                            </div>
                        </div>
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


<script>
    $(document).ready(function () {
        setTimeout(function() {
            var state = '{{$employee->state}}';
            $('[name="state"]').val(state);
            $('[name="state"]').selectpicker('refresh');
        }, 1000);
    });
</script>
@endsection
