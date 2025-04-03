@extends('layouts.home',['title' => trans('Employee Detail')])
@section('css')
<link rel="stylesheet" href="{{asset('rbtheme/css/glyphicons.min.css')}}">
<link rel="stylesheet" href="{{ asset('backend/css/tempus-dominus.min.css')}}">
<link rel="stylesheet" href="{{asset('rbtheme/css/employee-complete.css')}}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row min-vh-90 flex-center g-0 mt-5">
      <div class="col-lg-11 col-xl-9 py-3 position-relative mt-5 mb-5"><img class="bg-auth-circle-shape" src="{{ asset('rbtheme/img/icons/bg-shape.png')}}" alt="" width="250"><img class="bg-auth-circle-shape-2" src="{{ asset('rbtheme/img/icons/shape-1.png')}}" alt="" width="150">
        <div class="card overflow-hidden z-index-1">
          <div class="card-body p-0">
            <div class="row g-0">
              <div class="col-md-3 text-center bg-card-gradient pr-lg-0 pr-md-0">
                <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                  <div class="bg-holder bg-auth-card-shape employee-card-detail"></div>
                  {{--/.bg-holder--}}
                  <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="#!">{{ __('Working Time') }}</a>
                    <p class="opacity-75 text-white">{{ __('Working') }}</p>
                  </div>
                  
                </div>
                <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                  <p class="pt-3 text-white p-lg-1 padding-c">{{ __('Working_update') }}<br></p>
                </div>
              </div>
              <div class="col-md-9 d-flex flex-center">
                <div class="p-4 p-md-5 flex-grow-1">
                  <h3>{{ __('Services') }}</h3>
                  <form method="post" action="{{route('completeRegister')}}" id="employeeServiceForm" autocomplete="off">
                    @csrf
                    <input type="hidden" name="employee_id" value="{{ $employee_id }}">
                    <input type="hidden" name="parent_user_id" value="{{ isset($employee) ? $employee->parent_user_id : auth()->user()->parent_user_id }}">
                    <input type="hidden" name="user_id" value="{{ isset($employee) ? $employee->parent_user_id : auth()->user()->parent_user_id }}">
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="start-time">{{ __('Start Time') }} <span class="error">*</span></label>
                            <div class="input-group" id="datetimepickerRest2">
                                <input class="form-control" type="text" value="{{ (isset($findWorking) && isset($findWorking->start_time)) ? date('d/m/Y h:i A', strtotime($findWorking->start_time)) : old('start_time') }}" id="start-time" name="start_time" placeholder="HH:mm A"/>
                                <span class="input-group-text">
                                    <span class="far fa-clock"></span>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="finish-time">{{ __('Finish Time') }} <span class="error">*</span></label>
                            <div class="input-group" id="datetimepickerRest3">
                                <input class="form-control" type="text" value="{{ (isset($findWorking) && isset($findWorking->finish_time)) ? date('d/m/Y h:i A', strtotime($findWorking->finish_time)) : old('finish_time') }}" id="finish-time" name="finish_time" placeholder="HH:mm A"/>
                                <span class="input-group-text">
                                    <span class="far fa-clock"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="break-start-time">{{ __('Break Start Time') }} <span class="error">*</span></label>
                            <div class="input-group datetimepickerRestFull" id="datetimepickerRest4">
                                <input class="form-control" type="text" value="{{ (isset($findWorking) && isset($findWorking->break_start_time) && !empty($findWorking->break_start_time)) ? date('d/m/Y h:i A', strtotime($findWorking->break_start_time)) : old('break_start_time') }}" id="break-start-time" name="break_start_time" placeholder="HH:mm A"/>
                                <span class="input-group-text">
                                    <span class="far fa-clock"></span>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="break-end-time">{{ __('Break End Time') }} <span class="error">*</span></label>
                            <div class="input-group" id="datetimepickerRest5">
                                <input class="form-control" type="text" value="{{ (isset($findWorking) && isset($findWorking->break_end_time) && !empty($findWorking->break_end_time)) ? date('d/m/Y h:i A', strtotime($findWorking->break_end_time)) : old('break_end_time') }}" id="break-end-time" name="break_end_time" placeholder="HH:mm A"/>
                                <span class="input-group-text">
                                    <span class="far fa-clock"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="rest-time">{{ __('Padding Time') }} <span class="error">*</span></label>
                            <div class="input-group" id="datetimepickerRest">
                                <input class="form-control" type="text" placeholder="HH:mm" value="{{ (isset($findWorking) && isset($findWorking->rest_time)) ? date('d/m/Y h:i:s', strtotime($findWorking->rest_time)) : old('rest_time') }}" data-padding="{{ $custom->custom_time_slot }}" id="rest-time" name="rest_time" placeholder="HH:mm" autocomplete="off"/>
                                <span class="input-group-text">
                                    <span class="far fa-clock"></span>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3 col-sm-6"><label for="" class="form-label">{{ __('Job Title') }} <span class="error">*</span></label><input type="text" class="form-control" name="position" placeholder="{{ __('Job Position')}}" value="{{ isset($employee) ? $employee->position : auth()->user()->position }}" autocomplete="off"></div>
                    </div>
                    <h4>{{__('Social Profile')}}</h4>
                    <hr>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6"><label for="" class="form-label">{{ __('Facebook') }} <span class="error">*</span></label><input type="text" class="form-control" name="facebook" value="{{isset($employee) ? $employee->facebook : auth()->user()->facebook }}" placeholder="https://www.facebook.com/username" autocomplete="off"></div>
                        <div class="mb-3 col-sm-6"><label for="" class="form-label">{{ __('Instagram') }} <span class="error">*</span></label><input type="text" class="form-control" name="instagram" value="{{isset($employee) ? $employee->instagram : auth()->user()->instagram }}" placeholder="https://www.instagram.com/username" autocomplete="off"></div>
                    </div>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6"><label for="" class="form-label">{{ __('Twitter') }} <span class="error">*</span></label><input type="text" class="form-control"  name="twitter" value="{{isset($employee) ? $employee->twitter : auth()->user()->twitter }}" placeholder="https://www.twitter.com/username" autocomplete="off"></div>
                        <div class="mb-3 col-sm-6"><label for="" class="form-label">{{ __('Linkedin') }} <span class="error">*</span></label><input type="text" class="form-control" name="linkedin" value="{{isset($employee) ? $employee->linkedin : auth()->user()->linkedin }}" placeholder="https://www.linkedin.com/in/username" autocomplete="off"></div>
                    </div>
                    <div class="mb-3"><label class="form-label" for="card-confirm-password">{{ __('Working Days') }} <span class="error">*</span></label></div>
                    @php $days = array(__('Sunday'),__('Monday'),__('Tuesday'),__('Wednesday'),__('Thursday'),__('Friday'),__('Saturday'))@endphp
                    <div class="mb-3">
                        @foreach($days as $key => $day)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="days-checkbox-{{$key}}" name="days[]" value="{{ $key }}"/>
                            <label class="form-label" for="days-checkbox-{{$key}}">{{ $day }}</label>
                        </div>
                        @endforeach
                    </div>

                    @if($custom->categories == 1)
                    <div class="mb-3"><label class="form-label" for="card-confirm-password">{{ __('Categories') }}</label></div>
                    <div class="mb-3">
                        @foreach($categories as $category)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="categories-checkbox-{{ $category->id }}" value="{{ $category->id }}" name="category_id[]"/>
                            <label class="form-label" for="categories-checkbox-{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="mb-3"><label class="form-label" for="card-confirm-password">{{ __('Services') }} <span class="error">*</span></label></div>
                    <div class="mb-3" id="service_id">
                        @foreach($services as $key => $service)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="service-checkbox-{{ $key }}" name="service_id[{{ $service->category_id }}][]" data-check="service" data-duration="{{$service->duration}}" value="{{ $service->id }}"/>
                            <label class="form-label" for="service-checkbox-{{ $key }}">{{ $service->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="row gx-2 flex-center">
                        <div class="mb-3 col-md-4"><button class="btn btn-primary d-block w-100 mt-3" type="submit">{{ __('Update Detail') }}</button></div>
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
@endsection
@section('script')
<script src="{{ asset('backend/js/tempus-dominus.min.js')}}"></script>
<script src="{{asset('backend/js/datetimepicker-config.js')}}"></script>
<script src="{{asset('rbtheme/js/employee-detail.js')}}"></script>
@endsection