@extends('layouts.app')
@section('head')
@include('includes.head',['title'=> trans('Edit Profile')])
@endsection

@section('content')
<div class="mb-3 padding-space">
    <div class="container light-style flex-grow-1 container-p-y">
        @if(Session::has('message'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{Session::get('message')}}
                    </div>
                </div>
            </div>
            @endif
        <h4 class="font-weight-bold">
            {{ __('Account settings') }}
        </h4>
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row no-gutters row-bordered row-border-light">
                        
                        <div class="col-md-3 pt-0">
                            <form method="POST" id="profile-form" action="{{ route('users.update',Auth::user()->id) }}" enctype="multipart/form-data" autocomplete="off">
                                @method('PATCH')
                                @csrf
                                <div class="card-body media align-items-center">
                                    @if(!empty($user->profile))
                                    <img src="{{ asset('img/profile/'.$user->profile) }}" alt="{{ __('profile')}}" class="d-block ui-w-80" id="profileImage">
                                   
                                    @else
                                    <img src="{{ asset('rbtheme/img/image.png')}}" alt="{{ __('user-profile')}}" class="d-block ui-w-80 img-set">
                                    @endif
                                </div>
    
                                <div class="media-body">
                                    @if(!empty($user->profile))
                                    <label class="btn btn-outline-primary profile">
                                        {{ __('Change') }}
                                        <input type="file" id="pImage" name="profile"
                                            class="account-settings-fileinput">
                                    </label>
                                    @else
                                    <label class="btn btn-outline-primary profile">
                                        {{ __('Upload') }}
                                        <input type="file" id="pImage" name="profile"
                                            class="account-settings-fileinput">
                                    </label>
                                    @endif
    
                                </div>
                                <span class="z-index-1 text-white dark__text-white text-center fs--1 user_profile_after">
                                    <span class="d-inline"></span>
                                    <button  class="btn btn-danger" data-bs-title="Remove" title="{{__('Remove Profile Picture')}}"><i class="fa fa-trash"></i></button>
                                </span>
                            </form>
                            
                            <hr class="border-light m-0">
                            <ul class="nav nav-tabs list-group list-group-flush account-settings-links curser-set mt-3" role="tablist">
                                <li class="nav-item list-group-item-action">
                                    <a href="" class="nav-link list-group-item @if(session('frm') == 'general') in active @elseif(session('frm') == '') in active @endif" data-bs-toggle="tab" data-bs-target="#account-general">{{ __('Personal Information') }}</a>
                                </li>
                                <li class="nav-item list-group-item-action" id="changepassword-tab">
                                    <a href="" class="nav-link list-group-item @if(session('frm') == 'changepassword') active @endif" data-bs-toggle="tab" data-bs-target="#account-change-password">{{ __('Change Password') }}</a>
                                </li>
                                <li class="nav-item list-group-item-action" id="social-tab">
                                    <a href="" class="nav-link list-group-item @if(session('frm') == 'social') active @endif" data-bs-toggle="tab" data-bs-target="#social-profile">{{ __('Social Profile') }}</a>
                                </li>
                                @if(Auth::user()->role_id == 3)
                                <li class="nav-item list-group-item-action">
                                    @if(isset($employee->google_verify) && $employee->google_verify == true)
                                        <span class="list-group-item">{{__('Google Calendar:')}} <b>{{__('Connected')}}</b></span>
                                    @endif
                                </li>
                                <li class="nav-item list-group-item-action">
                                    @if(isset($employee->google_verify) && $employee->google_verify == true)    
                                    {{ Form::open(['method' => 'DELETE','id' => 'removeItem','route' => ['removegoogle',$employee->id]]) }}
                                        <span class="list-group-item remove-google-access btn-disconnect" style="background-color: #dc3545;color:#fff;font-size: 17px;">{{__('Disconnect Google Calendar')}}</span>
                                    {{ Form::close() }}
                                    @else
                                    <a href="{{ route('SendEmailGoogleCalenderLink',$user->id) }}" class="list-group-item btn-primary">{{ __('Connect With Google Calendar') }}</a>
                                    @endif
                                    {{-- <a href="{{ route('SendEmailGoogleCalenderLink',$user->id) }}" class="nav-link list-group-item" ><img alt="Google Calendar" title="Connect With Google Calendar"class="" height="25" width="25" src="{{ asset('img/employee/calendar.png')}}"/> </a> --}}
                                </li>
                                @endif
                            </ul>
                            <div class="text-danger mt-3 text-center">{{__('The image size should be maximum 8MB. Please select jpeg, jpg and png type of image') }}</div>
                        </div>
    
                        <div class="col-md-9 card-width">   
                            <div class="tab-content">
                                <div class="tab-pane fade @if(session('frm') == 'general') show active @elseif(session('frm') == '') show active  @endif" id="account-general">
                                    <form method="POST" action="{{ route('users.update', Auth::user()->id.'?frm=general') }}" id="account" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <div class="card-body card-size">
                                        <h2 class="font-weight-bold">
                                            {{ __('User Profile') }}
                                        </h2>
                                        <hr class="border-light m-0">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('First Name') }}</label>
                                                <input type="text" name="first_name" class="form-control mb-1" value="{{ ucfirst($user->first_name) }}" placeholder="{{ __('First Name') }}">
                                                @error('first_name')
                                                    <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Last Name') }}</label>
                                                <input type="text" name="last_name" class="form-control" value="{{ ucfirst($user->last_name) }}" placeholder="{{ __('Last Name') }}">
                                                @error('last_name')
                                                    <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('E-mail') }}</label>
                                                <input type="text" name="email" class="form-control mb-1" value="{{ $user->email}}" placeholder="{{ __('Email') }}">
                                                @error('email')
                                                    <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <input type="hidden" name="country_name" id="iso2" class="country-name" value="{{ $user->country_name }}">

                                            <input type="hidden" name="country_code" class="country_code" id="dialcode" value="{{ $user->country_code }}" data-country="{{ $user->country_name }}"  data-number="{{ $user->phone }}">

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Phone') }}</label>
                                                <input type="tel" name="phone" data-name="{{ $user->country_name }}" class="form-control intlTelInput country-phone-validation" id="phone" value="" placeholder="{{ __('Phone') }}">
                                                @error('phone')
                                                    <span class="error">{{$message}}</span>
                                                @enderror
                                                <span id="valid-msg" style="color: green;" class="d-none">✓ {{ __('Phone Number Valid') }}</span>
                                                <span id="error-msg" style="color: #bd5252;" class="d-none"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="form-label">{{ __('Job Title') }}</label>
                                                <input type="text" name="position" class="form-control" value="{{ ucfirst($user->position) }}" placeholder="{{ __('Job Title') }}" autocomplete="off">
                                            </div>
                                            <div class="text-right save">
                                                <button type="submit" class="btn-valid btn btn-primary">{{ __('Save changes') }}</button>
                                            </div>
                                            <a href="{{ route('dashboard') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                                        </div>
                                    </form>
                                </div>
                            
                                <div class="tab-pane fade @if(session('frm') == 'changepassword') show active @endif" id="account-change-password">
                                    <form method="POST" action="{{ route('updatePassword',['id' => Auth::user()->id.'?frm=changepassword']) }}" id="change-password" autocomplete="off">
                                        @method('PATCH')
                                        @csrf
                                        
                                        <div class="card-body card-size">
                                                <h2 class="font-weight-bold">
                                                    {{ __('Change Password') }}
                                                </h2>
                                                <hr class="border-light m-0">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Current password') }}</label>
                                                    <span toggle="old-password" class="toggle-password open mt-5"><i class="fa fa-eye-slash"></i></span>
                                                    <span toggle="old-password" class="toggle-password close d-none mt-5"><i class="fa fa-eye"></i></span>
                                                    <input type="password" name="old_password" class="form-control" id="old-password" placeholder="{{ __('Current Password') }}">
                                                </div>
    
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('New password') }}</label>
                                                    <span toggle="new-password" class="toggle-password open mt-5"><i class="fa fa-eye-slash"></i></span>
                                                    <span toggle="new-password" class="toggle-password close d-none mt-5"><i class="fa fa-eye"></i></span>
                                                    <input type="password" name="new_password" class="form-control" id="new-password" placeholder="{{ __('New Password') }}">
                                                </div>
    
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Confirm new password') }}</label>
                                                    <span toggle="confirm-password" class="toggle-password open mt-5"><i class="fa fa-eye-slash"></i></span>
                                                    <span toggle="confirm-password" class="toggle-password close d-none mt-5"><i class="fa fa-eye"></i></span>
                                                    <input type="password" name="confirm_password" class="form-control" id="confirm-password" placeholder="{{ __('Confirm New Password') }}">
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                                                </div>
                                                <a href="{{ route('dashboard') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
                                            </div>
                                    </form>
                                </div>
    
                                <div class="tab-pane fade @if(session('frm') == 'social') show active @endif" id="social-profile">
                                    <form method="POST" action="{{ route('users.social',['id' => Auth::user()->id.'?frm=social']) }}" id="social" autocomplete="off">
                                        @method('PATCH')
                                        @csrf
                                        <div class="card-body card-size">
                                            <h2 class="font-weight-bold">
                                                {{ __('Social Profile') }}
                                            </h2>
                                            <hr class="border-light m-0">
                                            <div class="mb-3">
                                                <label for="facebook" class="form-label">{{ __('Facebook') }}</label>
                                                <input type="text" name="facebook" class="form-control" value="{{$user->facebook}}" placeholder="https://www.facebook.com/username" autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="instagram" class="form-label">{{ __('Instagram') }}</label>
                                                <input type="text" name="instagram" class="form-control" value="{{$user->instagram}}" placeholder="https://www.instagram.com/username" autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="twitter" class="form-label">{{ __('Twitter') }}</label>
                                                <input type="text" name="twitter" class="form-control" value="{{$user->twitter}}" placeholder="https://www.twitter.com/username" autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="linkedin" class="form-label">{{ __('Linkedin') }}</label>
                                                <input type="text" name="linkedin" class="form-control" value="{{$user->linkedin}}" placeholder="https://www.linkedin.com/in/username" autocomplete="off">
                                            </div>
                                            <div class="text-right save">
                                                <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                                            </div>
                                            <a href="{{ route('dashboard') }}" class="back-button"><h4><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Back') }}</h4></a>
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
@section('scripts')
<script src="{{asset('backend/js/phone.js')}}"></script>
<script src="{{asset('backend/js/employee.js')}}"></script>
@endsection
