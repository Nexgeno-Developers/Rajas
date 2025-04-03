@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Site Setting')])
@endsection
@section('content')
<div class="mt-3 container-fluid">
    <div class=" light-style flex-grow-1 ">
        @include('includes.message-block')
        <h3 class="font-weight-bold t-center">
           {{ __('Site Settings') }}
        </h3>
        <div class="row justify-content-center margin">
            <div class="col-md-12 col-lg-8">
                <div class="row-bordered">
                    <form method="POST" action="{{ route('setting.siteUpdate',$site->id) }}" enctype="multipart/form-data" id="site-frm" autocomplete="off">
                        @csrf
                        <div class="card-body pb-1">
                            <h4 class="font-weight-bold">
                                {{ __('Site Configuration') }}
                            </h4>
                            <hr class="border-light m-0">
                            <div class="mb-3">
                                <label for="site" class="form-label">{{ __('Company Name') }}:</label>
                                <input type="text" class="form-control" value="{{ $site->company_name }}" name="company_name" placeholder="{{ __('Company Name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="site" class="form-label">{{ __('Site Title') }}:</label>
                                <input type="text" class="form-control" value="{{ $site->site_title }}" name="site_title" placeholder="{{ __('Site Title') }}"> 
                            </div>
                            <div class="mb-3">
                            <label for="about_company" class="form-label">{{ __('About Company') }}:</label>
                                <textarea name="about_company" class="form-control" id="about_company" cols="80" rows="5" placeholder="{{ __('Enter about company') }}">{{ $site->about_company }}</textarea>
                            </div>
                            <div class="mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}:</label>
                                <textarea name="address" class="form-control" id="address" cols="80" rows="3" placeholder="{{ __('Enter address') }}">{{ $site->address }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}:</label>
                                <input type="text" class="form-control" name="email" value="{{ $site->email }}" placeholder="{{ __('Enter Email') }}">
                            </div>

                            <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ $site->country_name }}">

                            <input type="hidden" name="country_code" id="dialcode" class="country_code" value="{{ $site->country_code }}" data-country="{{ $site->country_name }}" data-number="{{ $site->phone }}">

                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Phone') }}:</label>
                                <input type="tel" class="form-control country-phone-validation intlTelInput" name="phone" value="" id="phone" data-name="{{ $site->country_name }}">
                                {{-- placeholder="{{ __('Enter Phone Number') }}" --}}
                                <span id="valid-msg" style="color: green;" class="d-none">✓ {{ __('Phone Number Valid') }}</span>
                                <span id="error-msg" style="color: #bd5252;" class="d-none"></span>
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">{{ __('Facebook') }}:</label>
                                <input type="text" class="form-control" name="facebook" value="{{ $site->facebook }}" placeholder="https://www.facebook.com/your-username/">
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">{{ __('Twitter') }}:</label>
                                <input type="text" class="form-control" name="twitter" value="{{ $site->twitter }}" placeholder="https://twitter.com/your-username/">
                            </div>
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">{{ __('Linkedin') }}:</label>
                                <input type="text" class="form-control" name="linkedin" value="{{ $site->linkedin }}" placeholder="https://www.linkedin.com/in/your-username/">
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">{{ __('Instagram') }}:</label>
                                <input type="text" class="form-control" name="instagram" value="{{ $site->instagram }}" placeholder="https://www.instagram.com/your-username/">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">{{ __('Location') }}:</label>
                                <textarea name="location" id="location" class="form-control" rows="5" style="resize: none;">{{ html_entity_decode($site->location) ?? '' }}</textarea>
                            </div>
                         
                            @if(isset($site->location) && !empty($site->location))
                                @if(strpos($site->location, 'iframe') !== false)
                                    <div class="mb-3 location">
                                        <div class="map" style="min-width:400px;">
                                            {!!html_entity_decode($site->location) !!}
                                        </div>
                                    </div>
                                @else
                                    <iframe class="map location" style="min-width:400px;" src="{!! html_entity_decode($site->location) !!}"></iframe>
                                @endif
                            @endif
                            <div class="mb-3">
                                <label for="favicon" class="form-label">{{ __('Favicon') }}:</label>
                                <input type="file" class="form-control" id="favicon" name="favicon" value="{{ $site->favicon }}">
                                <div class="padding-space">
                                    @if(!empty($site->favicon))
                                    <img src="{{ asset('img/favicons/'.$site->favicon) }}" class="bg-image" alt="{{ __('favicon') }}" id="faviconimage" height="50px" width="50px">
                                    @else
                                    <img src="{{ asset('rbtheme/img/favicon.png') }}" class="bg-image" alt="{{ __('favicon') }}" id="faviconimage" height="50px" width="50px">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">{{ __('Logo') }}:</label>
                                <input type="file" class="form-control" id="Ilogo" name="logo" value="{{ $site->logo }}">
                                @if(!empty($site->logo))
                                <div class="padding-space"><img src="{{ asset('img/logo/'.$site->logo) }}" class="bg-image" alt="{{ __('Logo') }}" id="logoimage"  height="80px"></div>
                                @else
                                <div class="padding-space"><img src="{{ asset('rbtheme/img/logo.png') }}" class="bg-image" alt="{{ __('Logo') }}" id="logoimage"  height="80px"></div>
                                @endif
                            </div>
                            <div class="text-right mt-5 mb-5">
                                <button type="submit" class="btn btn-primary btn-valid">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('backend/js/phone.js')}}"></script>
@endsection
