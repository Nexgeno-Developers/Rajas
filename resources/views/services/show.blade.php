@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('View Service')])
@endsection
@section('content')
    <div class="mb-3 padding-space">
        <div class="container-fluid">
            @include('includes.message-block')
            <div class="row">
                <div class="offset-lg-3 offset-md-3 col-md-6">
                    <div class="panel panel-default panel-custom">
                        <div class="panel-heading panel-custom-heading">
                            <div class="btn-position">
                                <h3 class="panel-title">{{ucfirst($custom->custom_field_service)}}: {{ $service->name }}</h3>
                                {{ Form::open(['method' => 'DELETE','id' => 'deleteItem','route' => ['services.destroy', $service->id]]) }}
                                <button type="button" class="btn btn-default btn-delete btn-lg btn-padding btn-color">
                                <span class="glyphicon glyphicon-trash btn-delete-color"></span>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('services.store') }}" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="container-fluid">
                                @if($custom->categories == 1)
                                    @if(!empty($service->categories))
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="category">{{ucfirst($custom->custom_field_category)}}: </label>
                                                <input type="text" class="form-control custom-control" placeholder="category" id="category_id" value="{{ !empty($service->categories->name) ? $service->categories->name  : ''}}" name="name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name">{{ucfirst($custom->custom_field_service)}} {{ __('Name')}}: </label>
                                                <input type="text" class="form-control custom-control" id="name" value="{{ $service->name }}" name="name" readonly>
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name">{{ __('Price') }}:</label>
                                                <div class='input-group'>
                                                    <span class="input-group-text">
                                                       {{ $custom->currency_icon }}
                                                    </span>
                                                    <input type='text' class="form-control custom-control" name="price" value="{{ $service->price }}" placeholder="Price" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->


                                    <div class="row">

                                        <!-- Excluded Tax Price -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="excluded_tax_price" class="form-label">{{ __('Price') }}:</label>
                                                <div class='input-group'>
                                                    <span class="input-group-text">{{ $custom->currency_icon }}</span>
                                                    <input readonly type="number" step="0.01" id="excluded_tax_price" class="form-control custom-control" name="excluded_tax_price" value="{{Helper::removeTax($service->price, $service->tax)}}" placeholder="{{ __('Excluded Tax Price') }}">
                                                </div>
                                            </div>
                                        </div>                                    

                                        <!-- Tax (%) -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tax" class="form-label">{{ __('GST (%)') }}:</label>
                                                <input readonly type="number" step="0.01" id="tax" class="form-control custom-control" name="tax" value="{{ $service->tax }}" placeholder="{{ __('Tax') }}">
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="price" class="form-label">{{ __('Final Price') }}:</label>
                                                <div class='input-group'>
                                                    <span class="input-group-text">{{ $custom->currency_icon }}</span>
                                                    <input readonly type="number" step="0.01" id="price" class="form-control custom-control price @error('price') is-invalid @enderror" name="price" value="{{ $service->price }}" placeholder="{{ __('Price') }}">
                                                </div>
                                                @error('price')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="no_of_person_allowed" class="form-label">{{ __('Number of Person') }}:</label>
                                                <input readonly type="number" id="no_of_person_allowed" class="form-control custom-control" name="no_of_person_allowed" value="{{ $service->no_of_person_allowed }}" placeholder="{{ __('Enter number of persons') }}">
                                                @error('no_of_person_allowed')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="allowed_weight" class="form-label">{{ __('Weight') }} (kg):</label>
                                                <input readonly type="text" id="allowed_weight" class="form-control custom-control" name="allowed_weight" value="{{ $service->allowed_weight }}" placeholder="{{ __('Enter weight') }}">
                                                @error('allowed_weight')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>  

    
                                    <div class="row">
                                        <div class="col-lg-12" style="pointer-events:none11;">
                                            <div class="mb-3">
                                                <label for="description">{{ __('Description')}}: </label>
                                                <textarea  class="form-control tinymce-readonly custom-control" id="description" value="{{ $service->description }}" name="description" readonly>{{ $service->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name">{{ __('Duration')}}:</label>
                                                <div class='input-group datetimepickerRest'>
                                                    <input type='text' class="form-control custom-control" name="duration" value="{{  date('H:i', strtotime($service->duration)) }}" readonly/>
                                                    <span class="input-group-text">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name">{{ __('Cancel Appointment')}}:</label>
                                            <div class='input-group datetimepickerRest'>
                                                <input type='text' class="form-control custom-control" name="cancel_before" value="{{  date('H:i', strtotime($service->cancel_before)) }}" readonly/>
                                                <span class="input-group-text">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
    
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name">{{ __('Service Image')}}:</label>
                                            <p>
                                                @if(!empty($service->image))
                                                <img src="{{ asset('img/services/'.$service->image) }}" height="auto" width="100px" alt="{{ __('Service Image') }}" readonly>
                                                @else
                                                    <img src="{{ asset('rbtheme/img/placeholder.jpeg') }}" alt="{{ __('Service Image') }}" id="SImage"  height="auto" width="100px">
                                                @endif
                                            </p>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <a href="{{ route('services.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back')}}</h4></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
