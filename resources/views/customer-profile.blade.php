@extends('layouts.home',['title' => trans('Customer Profile')])

@section('content')
<section class="py-0 overflow-hidden light" id="banner">
    <div class="bg-holder overlay">
    </div>
    <div class="container mt-lg-7 mb-5 p-3">
    @if(Session::has('message'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{Session::get('message')}}
                    </div>
                </div>
            </div>
            @endif
    <div class="row">
            <div class="col-12">
              <div class="card mb-3 btn-reveal-trigger">
                <div class="card-header position-relative min-vh-25 mb-8">
                 <form method="POST" id="profile-form" action="{{ route('users.update',Auth::user()->id) }}" enctype="multipart/form-data" autocomplete="off">
                 @method('PATCH')
                 @csrf
                  <div class="cover-image">
                    <div class="bg-holder rounded-3 rounded-bottom-0 customer-profile-cover"></div>
                  </div>
                  <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                    
                    <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                    @if(!empty($user->profile))
                     <img src="{{ asset('img/profile/'.$user->profile) }}" id="profileImage" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" />
                     @else
                     <img src="{{ asset('rbtheme/img/image.png')}}" alt="user-profile" data-dz-thumbnail="data-dz-thumbnail">
                     @endif
                      <input class="d-none" id="profile-image" name="profile" type="file" />
                      <label class="mb-0 overlay-icon d-flex flex-center " for="profile-image"><span class="bg-holder overlay overlay-0"></span>
                        <span class="z-index-1 text-white dark__text-white text-center fs--1">
                          @if(!empty($user->profile))
                            <span class="fas fa-camera"></span>
                            <span class="d-block">{{ __('Change') }}</span>
                          <span class="d-block"></span><button class="remove-btn" data-bs-title="Remove" title="{{ __('Remove Profile Picture') }}"><i class="fa fa-trash"></i></button></span>
                          @else
                            <span class="fas fa-camera"></span>
                            <span class="d-block">{{ __('Upload') }}</span>
                            @endif
                        </span>
                      </label>
                    </div>
                   
                  </div>
                  <div class="profile-name-position">
                     <h3>{{ $user->first_name.' '.$user->last_name }}</h3>
                  </div>
                 </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-0 mb-2">
            <div class="col-lg-6 pe-lg-2">
              <div class="card mb-3 ">
                <div class="card-header">
                  <h5 class="mb-0">{{ __('Profile Settings') }}</h5>
                </div>
                <div class="card-body bg-light">
                  <form class="row g-3" method="POST" action="{{ route('users.update',Auth::user()->id) }}" id="profile-detail-form" autocomplete="off">
                  @method('PATCH')
                    @csrf
                    <div class="col-lg-6"> <label class="form-label" for="first-name">{{ __('First Name') }}</label><input class="form-control" id="first-name" name="first_name" type="text" value="{{ $user->first_name}}" /></div>
                    <div class="col-lg-6"> <label class="form-label" for="last-name">{{ __('Last Name') }}</label><input class="form-control" id="last-name" name="last_name" type="text" value="{{ $user->last_name}}" /></div>
                    <div class="col-lg-6"> <label class="form-label" for="email1">{{ __('Email') }}</label><input class="form-control" id="email1" type="text" name="email" value="{{ $user->email}}" /></div>
                    
                    <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ $user->country_name }}">

                                    <input type="hidden" name="country_code" class="country_code" id="dialcode" value="{{ $user->country_code }}" data-country="{{ $user->country_name }}"  data-number="{{ $user->phone}}">
                    
                    <div class="col-lg-6"> <label class="form-label" for="email2">{{ __('Phone') }}</label>
                          <input class="form-control intlTelInput country-phone-validation" id="email2" type="text" name="phone" value="" data-name="{{ $user->country_name }}"/>
                          <span id="valid-msg" style="color: green;" class="d-none phone-valid-msg">✓ {{ __('Phone Number Valid') }}</span>
                          <span id="error-msg" style="color: #bd5252;" class="d-none phone-error-msg"></span>
                    </div>
                    
                    <div class="col-12 d-flex justify-content-end mt-3"><button class="btn-valid btn btn-primary" type="submit">{{ __('Update') }}</button></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6 ps-lg-2">
              <div class="sticky-sidebar">
                <div class="card mb-3">
                  <div class="card-header">
                    <h5 class="mb-0">{{ __('Change Password') }}</h5>
                  </div>
                  <div class="card-body bg-light">
                    <form method="POST" action="{{ route('updatePassword',['id' => Auth::user()->id]) }}" id="changePassword-form" autocomplete="off">
                    @method('PATCH')
                    @csrf
                      
                      <div class="row">
                        <div class="col-md-12">
                          <label class="form-label" for="old-password">{{ __('Current Password') }}</label>
                          <span toggle="old-passworda" class="toggle-password open"><i class="fa fa-eye-slash"></i></span>
                          <span toggle="old-passworda" class="toggle-password close d-none"><i class="fa fa-eye"></i></span>
                          <input class="form-control" name="old_password" placeholder="{{ __('Current Password') }}" id="old-passworda" type="password" />
                          @if(Session::has('password-message'))
                              <span class="error">{{Session::get('password-message')}}</span>
                          @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="new-password">{{ __('New Password') }}</label>
                            <span toggle="new-passworda" class="toggle-password open"><i class="fa fa-eye-slash"></i></span>
                            <span toggle="new-passworda" class="toggle-password close d-none"><i class="fa fa-eye"></i></span>
                            <input class="form-control" placeholder="{{ __('New Password') }}" name="new_password" id="new-passworda" type="password" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="confirm-password">{{ __('Confirm Password') }}</label>
                            <span toggle="confirm-passworda" class="toggle-password open"><i class="fa fa-eye-slash"></i></span>
                            <span toggle="confirm-passworda" class="toggle-password close d-none"><i class="fa fa-eye"></i></span>
                            <input class="form-control" placeholder="{{ __('Confirm Password') }}" name="confirm_password" id="confirm-passworda" type="password" />
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                          <button class="btn btn-primary" type="submit">{{ __('Update Password') }} </button>
                      </div>
                      </div>
                     
                    </form>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{asset('backend/js/phone.js')}}"></script>
@endsection
