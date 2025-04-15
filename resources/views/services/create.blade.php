@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Create New Service')])
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
                            <h3 class="panel-title">{{ __('Create New Service') }}</h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('services.store') }}" method="post" id="serviceDetail" enctype="multipart/form-data" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="container-fluid">
    
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    @if($custom->categories == 1)
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="category" class="form-label">{{ucfirst($custom->custom_field_category)}}: </label>
                                                    <select name="category_id" id="category_id" class="form-control custom-control">
                                                        <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_category)}}</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (old('category_id') == $category->id) ? 'selected' : ''}}>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <span class="error-message">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ucfirst($custom->custom_field_service)}} {{ __('Name') }}: </label>
                                                <input type="text" class="form-control custom-control @error('name') is-invalid @enderror" id="name" value="{{old('name')}}" name="name"
                                                placeholder="{{ucfirst($custom->custom_field_service)}} {{ __('name') }}">
                                                @error('name')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ __('Price')}}:</label>
                                                <div class='input-group'>
                                                    <span class="input-group-text">
                                                       {{ $custom->currency_icon }}
                                                    </span>
                                                    <input type="text" class="form-control price @error('price') is-invalid @enderror" name="price" value="{{old('price')}}" placeholder="{{ __('Price') }}">
                                                </div>
                                                @error('price')
                                                        <span class="error-message">{{ $message }}</span>
                                                @enderror
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
                                                    <input type="number" step="0.01" id="excluded_tax_price" class="form-control" name="excluded_tax_price" value="{{ old('excluded_tax_price') }}" placeholder="{{ __('Excluded Tax Price') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tax (%) -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tax" class="form-label">{{ __('GST (%)') }}:</label>
                                                <input type="number" step="0.01" id="tax" class="form-control" name="tax" value="{{ old('tax', 0) }}" placeholder="{{ __('Tax') }}">
                                            </div>
                                        </div>


                                        <!-- Price -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="price" class="form-label">{{ __('Final Price') }}:</label>
                                                <div class='input-group'>
                                                    <span class="input-group-text">{{ $custom->currency_icon }}</span>
                                                    <input required readonly type="number" step="0.01" id="price" class="form-control price @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="{{ __('Price') }}">
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
                                                <input required type="number" id="no_of_person_allowed" class="form-control @error('no_of_person_allowed') is-invalid @enderror" name="no_of_person_allowed" value="{{ old('no_of_person_allowed') }}" placeholder="{{ __('Enter number of persons') }}">
                                                @error('no_of_person_allowed')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="allowed_weight" class="form-label">{{ __('Weight') }} (kg):</label>
                                                <input required type="text" id="allowed_weight" class="form-control @error('allowed_weight') is-invalid @enderror" name="allowed_weight" value="{{ old('allowed_weight') }}" placeholder="{{ __('Enter weight') }}">
                                                @error('allowed_weight')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>                                    

    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label">{{ __('Description')}}: </label>
                                                <textarea  class="form-control tinymce-editor custom-control @error('description') is-invalid @enderror" placeholder="{{ __('Description')}}" id="description" value="{{old('discription')}}" name="description">{{old('description')}}</textarea>
                                                @error('description')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ __('Service Duration')}}:</label>
                                                <div class='duration_hr_div input-group' id="datetimepickerRest">
                                                    <input type='text' class="form-control time @error('duration') is-invalid @enderror timeDuration" value="{{old('duration')}}" name="duration" id="duration" placeholder="{{ __('Duration')}}" autocomplete="off"/>
                                                    <span class="input-group-text">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                                <div class="duration_24hr_div_optional mt-2">
                                                    <input type="checkbox" name="duration_24hr" id="service_duration" value="1">
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
                                                <input type="checkbox" id="approve" name="auto_approve" value="1">
                                                <label for="Approve" class="form-label">{{ __('Auto Approved')}}</label>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ __('Cancel Appointment Duration')}}:</label>
                                                <div class='input-group' id="datetimepickerRest1">
                                                    <input type='text' class="form-control time @error('cancel_before') is-invalid @enderror timeDuration" placeholder="{{ __('Cancel Appointment') }}" value="{{old('cancel_before')}}" name="cancel_before" id="cancel-before"/>
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
                                                <label for="service_image" class="form-label">{{ __('Service Image') }}:</label>
                                                <input type="file" class="form-control " id="service_image" name="image" data-value="">
                                                @error('image')
                                                        <span class="error-message">{{ $message }}</span>
                                                @enderror
                                                <div class="mt-3 text-danger">{{ __('The image size should be maximum 8MB. Please select jpeg, jpg and png type of image') }}</div>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                <hr>
    
                                <div class="row">
                                    <div class="offset-sm-4 col-sm-4 col-xs-offset-2 col-xs-8">
                                        <button type="submit" class="btn btn-default custom-btn btn-block">{{ ('Submit') }}</button>
                                    </div>
                                </div>
                                <a href="{{ route('services.index') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
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

<script>
$(function () {
    function updatePriceFromExcluded() {
        let excluded = parseFloat($('#excluded_tax_price').val()) || 0;
        let taxRate = parseFloat($('#tax').val()) || 0;

        let taxAmount = excluded * (taxRate / 100);
        let price = excluded + taxAmount;

        $('#price').val(Math.ceil(price)); // Final price including tax
    }

    // Only trigger from excluded_tax_price and tax
    $('#excluded_tax_price, #tax').on('input', function () {
        updatePriceFromExcluded();
    });
});
</script>

@endsection
