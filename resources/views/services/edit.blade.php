@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Edit Service')])
    <link rel="stylesheet" href="{{asset('backend/css/tempus-dominus.min.css')}}">
@endsection
@section('content')
    <div class="mb-3 padding-space">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-lg-3 offset-md-3 col-md-6">
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
                            <h3 class="panel-title">{{ucfirst($custom->custom_field_service)}}: {{ $service->name }}</h3>
                        </div>
                        <div class="panel-body">
                            {{ Form::model($service, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['services.update', $service->id],'id'=>'serviceDetail']) }}
                            {{ csrf_field() }}
                            <div class="container-fluid">
                            @if($custom->categories == 1)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="category">{{ucfirst($custom->custom_field_category)}}: </label>
                                            <select name="category_id" id="category_id" class="form-control custom-control">
                                                <option value="">{{ __('Select')}} {{ucfirst($custom->custom_field_category)}}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @if($service->category_id == $category->id) {{ 'selected' }} 
                                                @endif>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category_id')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name">{{ucfirst($custom->custom_field_service)}} {{ __('Name') }}: </label>
                                            <input type="text" class="form-control custom-control @error('name') is-invalid @enderror" id="name" value="{{ $service->name }}" name="name" 
                                                placeholder="{{ucfirst($custom->custom_field_service)}} {{ __('name') }}">
                                                @error('name')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name">{{ __('Price') }}:</label>
                                                <div class='input-group'>
                                                    <span class="input-group-text">
                                                       {{ $custom->currency_icon }}
                                                    </span>
                                                    <input type='text' class="form-control custom-control @error('price') is-invalid @enderror" name="price" value="{{ $service->price }}" placeholder="{{ __('Price') }}" autocomplete="off">
                                                </div>
                                                @error('price')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="description">{{ __('Description')}}: </label>
                                                <textarea  class="form-control custom-control @error('description') is-invalid @enderror" id="description"  name="description">{{ $service->description }}</textarea>
                                                @error('description')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name">{{ __('Duration')}}:</label>
                                                <div class='duration_hr_div {{ $service->duration == '23:59:59' ? 'd-none': ''}} input-group' id="datetimepickerRest">
                                                    <input type='text' class="form-control custom-control @error('duration') is-invalid @enderror timeDuration" name="duration" id="duration" value="{{ $service->duration == '23:59:59' ? '' : date('Y-m-d H:i', strtotime($service->duration)) }}" autocomplete="off">
                                                    <span class="input-group-text">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                                <div class="duration_24hr_div_optional {{ $service->duration != '23:59:59' ? '': ''}} mt-2">
                                                    <input type="checkbox" name="duration_24hr" id="service_duration" value="1" {{ $service->duration == '23:59:59' ? 'checked': ''}}>
                                                    <label for="service_duration">{{__('24 Hours Service Duration')}}</label>
                                                </div>
                                                @error('duration')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <input type="checkbox" id="approve" name="auto_approve" value="1" 
                                                  {{ ($service->auto_approve == 1 ) ? "checked": "" }} > 
                                                <label for="approve">{{ __('Auto Approved') }}</label>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name">{{ __('Cancel Appointment') }}:</label>
                                                <div class='input-group' id="datetimepickerRest1">
                                                    <input type='text' class="form-control custom-control time @error('cancel_before') is-invalid @enderror timeDuration" id="cancel-before" name="cancel_before" value="{{ date('Y-m-d H:i', strtotime($service->cancel_before)) }}"  autocomplete="off">
                                                    
                                                    <span class="input-group-text">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
    
                                                </div>
                                                @error('cancel_before')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="service_image">{{ __('Service Image')}}:</label>
                                                <input type="file" class="form-control" id="service_image" name="image" data-value="{{ $service->image }}">
                                                @error('image')
                                                        <span class="error-message">{{ $message }}</span>
                                                @enderror
                                                <div class="padding-space">
                                                    @if(!empty($service->image))
                                                    <img src="{{ asset('img/services/'.$service->image) }}" alt="{{ __('service image')}}" id="SImage"  height="auto" width="100px">
                                                    @else
                                                    <img src="{{ asset('rbtheme/img/placeholder.jpeg') }}" alt="{{ __('service image')}}" id="SImage"  height="auto" width="100px">
                                                    @endif
                                                </div>
                                                <div class="text-danger">{{ __('The image size should be maximum 8MB. Please select jpeg, jpg and png type of image') }}</div>
                                            </div>
                                        </div>
                                    </div>
    
                                <hr>
    
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-default custom-btn btn-block">{{ __('Submit')}}</button>
                                    </div>
                                    
                                   
                                </div>
                                <a href="{{ route('services.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back')}}</h4></a>
                            </div>
                            {{ Form::close() }}
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
@endsection
