@extends('layouts.app')
@section('head')
@include('includes.head',['title'=> trans('Employees')])
@endsection
@section('css')
{{-- <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet"></script> --}}
@endsection
@section('content')
<div class="row p-2">
    @include('includes.message-block')
    <div class="col-sm-12 col-mobile">
        <div class="board-box">
            <div class="board-title">
                <h2>{{ __('List of all employees') }} <a href="{{ route('employees.create') }}" class="add-new-employee"><span
                            class="fa fa-plus pull-c-right"></span></a></h2>
                    
            </div>
    
            <div class="table-style">
                <div class="table-responsive">
                    <table class="table table-hover data-table" id="emp-table">
                        <thead>
                            <tr>
                                <th>{{ __('SR No.') }}</th>
                                <th>{{ __('First Name') }}</th>
                                <th>{{ __('Last Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                @if($custom->categories == 1)
                                    <th>{{ucfirst($custom->custom_field_category)}}</th>
                                @endif
                                <th>{{ucfirst($custom->custom_field_service)}}</th>
                                <th>{{ __('Status') }}</th>
                                <th></th>
                                <th class="custom-column">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <th>{{ $rowIndex++ }}</th>
                                <td>{{ ucfirst($employee->first_name) }}</td>
                                <td>{{ ucfirst($employee->last_name) }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->country_code.$employee->phone }}</td>
                                @if($custom->categories == 1)
                                    <td>{{ ucfirst($employee->categories) }}</td>
                                @endif
                                <td>{{ $employee->services }}</td>
                                <td>
                                    <input type="checkbox" name="status" class="status" value="1" @if($employee->status == 1) {{ 'checked' }} @endif 
                                    data-toggle="toggle" data-style="slow" data-onstyle="success" data-offstyle="danger" data-off={{ __('Inactive') }} 
                                    data-employee_id="{{$employee->id}}" data-on="{{ __('Active') }}">
                                </td>
                                <td>
                                    {{-- <a href="{{ Helper::googlecalendar($employee->email, $employee->id) }}"> --}}
                                    <a @if($employee->google_verify == true) {{ 'disabled' }} href="javascript:void(0)" class="remove-google" data-id="{{$employee->id}}" @else onclick="return googleCalendarEmailConfirmation(this);" data-href="{{ route('SendEmailGoogleCalenderLink',$employee->id) }}" @endif>
                                        @if(isset($employee->google_verify) && $employee->google_verify == true)  
                                        {{ Form::open(['method' => 'DELETE','id' => 'removeItem','route' => ['removegoogle',$employee->id]]) }}
                                            <span class="employee-badge"><i class="fa fa-check d-flex btn-disconnect"></i></span>
                                        {{ Form::close() }}
                                        @endif
                                        <img alt="Connect With Google Calendar" title="Connect With Google Calendar" class="google-calendar mt-3" height="25" width="25" src="{{ asset('img/employee/calendar.png')}}">
                                    </a>
                                    {{-- <button type="submit" id="gcalendar" class="btn shadow-none mt-1" name="submit" value="">
                                        <img alt="Google Calendar" title="Connect With Google Calendar" class="" height="30" width="30" src="{{ asset('img/employee/calendar.png')}}"/>
                                    </button> --}}
                                </td>
                                <td>
                                    <a class="btn btn-default btn-lg" href="{{ route('employees.show',$employee->id) }}">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                    <a class="btn btn-default btn-lg" href="{{ route('employees.edit',$employee->id) }}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a class="btn btn-default btn-lg" title="{{ __('appointment') }}" href="{{ route('employees.appointment',$employee->id) }}">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('backend/js/employee.js')}}"></script>
@endsection

