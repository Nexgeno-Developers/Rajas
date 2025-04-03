@extends('layouts.app')
@section('head')
@include('includes.head',['title'=> trans('General Setting')])
@endsection
@section('css')
<link href="{{ asset('rbtheme/css/loader.css') }}" rel="stylesheet" id="style-default">
@endsection
@section('content')
<div class="mt-3">
    <div class=" light-style flex-grow-1 container-p-y container-padding">
        @include('includes.message-block')
        <h3 class="font-weight-bold t-center">
            {{ __('General Settings') }}
        </h3>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="smtp-frm"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('SMTP Configuration') }}
                        </h4>
                        <img src="{{ asset('rbtheme/img/smtp-logo.png') }}" class="img-right" height="40px" width="40px"
                            alt="{{ __('Smtp logo') }}">
                        <hr class="border-light m-0">
                        <div class="mb-3 status-mode">
                            <label for="mail" class="form-label">{{ __('SMTP Mail') }}:</label>
                            <input type="checkbox" id="smtp_mail" name="smtp_mail" value="1" data-toggle="toggle"
                                data-style="slow" data-onstyle="success" data-offstyle="danger"
                                data-off="{{ __('InActive') }}" data-on="{{ __('Active') }}"
                                {{ ($smtp->smtp_mail == 1) ? "checked": "" }}>
                        </div>
                        <div class="mb-3">
                        {{-- pull-lg-right --}}
                            <label for="mail" class="form-label">{{ __('Mode') }}:</label>
                            <button type="button" class="btn btn-primary testMail" data-bs-toggle="modal" data-bs-target="#testMailModel">
                               {{ __('Test Mail')}}
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('SMTP Email') }}:</label>
                            <input type="email" class="form-control" name="smtp_email" value="{{ $smtp->smtp_email }}"
                                id="email" placeholder="{{ __('SMTP Email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('SMTP Password') }}:</label>
                            <input type="password" class="form-control" name="smtp_password"
                                value="{{ $smtp_password }}" id="password"
                                placeholder="{{ __('Smtp Password') }}">
                        </div>
                        <div class="mb-3">
                            <label for="host" class="form-label">{{ __('SMTP Host') }}:</label>
                            <input type="text" class="form-control" name="smtp_host" value="{{ $smtp->smtp_host }}"
                                placeholder="{{ __('SMTP Host') }}">
                        </div>
                        <div class="mb-3">
                            <label for="port" class="form-label">{{ __('SMTP Port') }}:</label>
                            <input type="text" class="form-control" name="smtp_port" value="{{ $smtp->smtp_port }}"
                                placeholder="{{ __('SMTP Port') }}">
                        </div>

                        <div class="save">
                            <button type="submit" class="btn btn-primary float-right-c">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="custom-frm"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('Custom Labels Configuration') }}
                        </h4>
                        <img src="{{ asset('rbtheme/img/custom-logo.jpg') }}" class="img-right" height="35px"
                            width="40px" alt="{{ __('Smtp logo') }}">
                        <hr class="border-light m-0">
                        <div class="mb-3">
                            <label for="stripe" class="form-label">{{ __('Custom Label Employee') }}</label>
                            <input type="text" class="form-control" name="custom_field_text"
                                value="{{ $smtp->custom_field_text }}" placeholder="{{ __('Custom Field Text') }}">
                        </div>
                        <div class="mb-3">
                            <label for="stripe" class="form-label">{{ __('Custom Label Category') }}</label>
                            <input type="text" class="form-control" name="custom_field_category"
                                value="{{ $smtp->custom_field_category }}"
                                placeholder="{{ __('Custom Field category') }}">
                        </div>
                        <div class="mb-3">
                            <label for="stripe" class="form-label">{{ __('Custom Label Service') }}</label>
                            <input type="text" class="form-control" name="custom_field_service"
                                value="{{ $smtp->custom_field_service }}"
                                placeholder="{{ __('Custom Field service') }}">
                        </div>
                        <div class="text-right mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="custom-frm"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('Google Calendar Configuration') }}
                        </h4>

                        <img src="{{ asset('img/employee/calendar.png') }}" class="img-right" height="35px"
                            width="40px" alt="{{ __('Google Calendar') }}">
                        <hr class="border-light m-0">
                        <div class="mb-3">
                            <label for="cliend_id" class="form-label">{{ __('Client ID') }}</label>
                            <input type="text" class="form-control" name="google_client_id"
                                value="{{ $smtp->google_client_id }}" placeholder="{{ __('Google Calendar Client ID') }}">
                        </div>
                        <div class="mb-3">
                            <label for="client_secret" class="form-label">{{ __('Client Secret') }}</label>
                            <input type="text" class="form-control" name="google_client_secret"
                                value="{{ $smtp->google_client_secret }}"
                                placeholder="{{ __('Google Calendar Client Secret') }}">
                        </div>
                        <div class="text-right mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="currency-frm"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('Currency Configuration') }}
                        </h4>
                        <img src="{{ asset('rbtheme/img/currency-logo.jpg') }}" class="img-right" height="40px"
                            width="50px" alt="{{ __('Smtp logo') }}">
                        <hr class="border-light m-0">
                        <div class="mb-3">
                            <label for="currency" class="form-label"> {{ __('Currency') }}:</label>
                            <input type="text" class="form-control" value="{{ $smtp->currency }}" name="currency"
                                placeholder="{{ __('Currency') }}">
                        </div>
                        <div class="mb-3">
                            <label for="currency-icon" class="form-label"> {{ __('Currency Symbol') }}:</label>
                            <input type="text" class="form-control" value="{{ $smtp->currency_icon }}"
                                name="currency_icon" placeholder="{{ __('Currency Symbol') }}">
                        </div>
                        <div class="text-right mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="timezone-frm"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('Time Zone Configuration') }}
                        </h4>
                        <img src="{{ asset('rbtheme/img/timezone.jpg') }}" class="img-right" height="40px" width="50px"
                            alt="{{ __('Smtp logo') }}">
                        <hr class="border-light m-0">
                        <div class="mb-3">
                            <label for="timezone" class="form-label"> {{ __('Time Zone') }}:</label>
                            <input type="text" class="form-control" value="{{ $smtp->timezone }}" name="timezone"
                                placeholder="{{ __('Time Zone') }}">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label"> {{ __('Date Format') }}:</label>
                            <select class="form-select date-format" aria-label="Default select example" name="date_format" data-value="{{ $smtp->date_format }}">
                                <option value="">{{__('Select Date Format')}}</option>
                                <option value="Y-m-d">{{date('Y-m-d', strtotime('today'))}}</option>
                                <option value="y-m-d">{{date('y-m-d', strtotime('today'))}}</option>
                                <option value="m/d/y">{{date('m/d/y', strtotime('today'))}}</option>
                                <option value="m/d/Y">{{date('m/d/Y', strtotime('today'))}}</option>
                                <option value="d/m/y">{{date('d/m/y', strtotime('today'))}}</option>
                                <option value="d/m/Y">{{date('d/m/Y', strtotime('today'))}}</option>
                                <option value="y/m/d">{{date('y/m/d', strtotime('today'))}}</option>
                                <option value="Y/m/d">{{date('Y/m/d', strtotime('today'))}}</option>
                                <option value="m-d-y">{{date('m-d-y', strtotime('today'))}}</option>
                                <option value="m-d-Y">{{date('m-d-Y', strtotime('today'))}}</option>
                                <option value="d-m-y">{{date('d-m-y', strtotime('today'))}}</option>
                                <option value="d-m-Y">{{date('d-m-Y', strtotime('today'))}}</option>
                                <option value="d.m.y">{{date('d.m.y', strtotime('today'))}}</option>
                                <option value="d.m.Y">{{date('d.m.Y', strtotime('today'))}}</option>
                                <option value="l, F j, Y">{{date('l, F j, Y', strtotime('today'))}}</option>
                                <option value="M, d, Y">{{date('M, d, Y', strtotime('today'))}}</option>
                            </select>
                        </div>
                        <div class="text-right mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="timeslot-frm"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('Time Slot Configuration') }}
                        </h4>
                        <img src="{{ asset('rbtheme/img/time.jpg') }}" class="img-right" height="45px" width="150px"
                            alt="Smtp logo">
                        <hr class="border-light m-0">
                        <div class="mb-3">
                            <input class="form-check-input" type="radio" name="custom_time_slot" id="custom_time_slot_before" value="1"
                                {{ ($smtp->custom_time_slot == "1")? "checked" : "" }} />
                            <label class="form-check-label" for="custom_time_slot_before">
                                {{ __('Add before selection') }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="radio" name="custom_time_slot" id="custom_time_slot_after" value="2"
                                {{ ($smtp->custom_time_slot == "2")? "checked" : "" }} />
                            <label class="form-check-label" for="custom_time_slot_after">
                                {{ __('Add after selected slot') }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="radio" name="custom_time_slot" id="custom_time_slot_no" value="0"
                                {{ ($smtp->custom_time_slot == "0")? "checked" : "" }} />
                            <label class="form-check-label" for="custom_time_slot_no">
                                {{ __('No Padding time') }}
                            </label>
                        </div>
                        <div class="text-right mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card row-bordered card-setting">
                    <form method="POST" action="{{ route('setting.update',Auth::user()->id) }}" id="category-menu"
                        autocomplete="off">
                        @csrf
                        <h4 class="font-weight-bold mb-4">
                            {{ __('Admin Configuration') }}
                        </h4>
                        <img src="{{ asset('rbtheme/img/category.jpg') }}" class="img-right" height="40px" width="50px"
                            alt="{{ __('Categories') }}">
                        <input type="hidden" name="admin_config" value="true">
                        <hr class="border-light m-0">
                        <div class="mb-3">
                            <label for="mail" class="form-label">{{ __('Include Categories ?') }}</label>
                            <input type="checkbox" id="category_menu" name="categories" value="1" data-toggle="toggle"
                                data-style="slow" data-onstyle="success" data-offstyle="danger"
                                data-off="{{ __('No') }}" data-on="{{ __('Yes') }}"
                                {{ ($smtp->categories == 1) ? "checked": "" }}>
                        </div>
                        <div class="mb-3">
                            <label for="mail" class="form-label">{{ __('Include Employees ?') }}</label>
                            <input type="checkbox" id="employee_menu" name="employees" value="1" data-toggle="toggle"
                                data-style="slow" data-onstyle="success" data-offstyle="danger"
                                data-off="{{ __('No') }}" data-on="{{ __('Yes') }}"
                                {{ ($smtp->employees == 1) ? "checked": "" }}>
                        </div>
                        <div class="mb-3">
                            <label for="mail" class="form-label">{{ __('Allow Payment Later ?') }}</label>
                            <input type="checkbox" id="payment_later" name="is_payment_later" value="1"
                                data-toggle="toggle" data-style="slow" data-onstyle="success" data-offstyle="danger"
                                data-off="{{ __('No') }}" data-on="{{ __('Yes') }}"
                                {{ (isset($smtp->is_payment_later) && $smtp->is_payment_later == 1) ? "checked": "" }}>
                        </div>
                        <div class="text-right mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="testMailModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="testMailModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="checkEmail" action="javascript:;" class="w-100" method="POST" autocomplete="off">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Checking Mail Configuration')}}</h5>
                    <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="to" class="col-form-label">{{ __('To:') }} <span class="error">*</span></label>
                        <input type="email" class="form-control" name="to" placeholder="{{__('Enter Mail Address')}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary verifySmtp">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>                
@endsection
