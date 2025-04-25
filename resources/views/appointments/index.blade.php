@extends('layouts.app')
@section('head')
    @include('includes.head',['title'=> trans('Appointments')])
@endsection
@section('content')
    @include('includes.message-block')
    <div class="row p-md-4 p-2">
        <div class="col-sm-12 col-mobile">
            <div class="board-box">
                <div class="board-title">
                    <div class="row">
                        <div class="col-md-6"><h2>{{ __('List of all appointments') }} </h2></div>
                        <div class="col-md-6"><a href="{{ route('appointments.create') }}" class="add-new-employee btn btn-secondary pull-c-right"> <span class="fa fa-plus"></span> Create appointments</a></div>
                    </div>
                       
                </div>
                <form method="post" id="filter-form" action="{{ route('appointment-filter') }}" autocomplete="off">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xl-2 col-lg-6 p-2 appointment-date-filter">
                            <div class="form-group">
                                <label class="form-label">{{ucfirst($custom->custom_field_service)}}:</label>
                                <select name="service_id" id="service_id" class="form-control custom-control">
                                    <option value="">{{ __('Select') }} {{ucfirst($custom->custom_field_service)}}</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->name }}" data-id="{{$service->id}}" {{ (isset($data) && $service->id == $data['service_id']) ? 'selected' : '' }}>{{$service->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($custom->employees == 1)
                            @if(session('frm') != 'employee')
                            <div class="col-sm-6 col-xl-2 col-lg-6 p-2 appointment-date-filter">
                                <div class="form-group">
                                    <label class="form-label previous-serviceid" data-previous-serviceid="{{ old('employee_id') }}" data-customFieldText="{{ ucfirst($custom->custom_field_text) }}">{{ucfirst($custom->custom_field_text)}}:</label>
                                    <select name="employee_id" id="employee_id" class="form-control custom-control">
                                        <option value="" >{{ __('Select') }} {{ucfirst($custom->custom_field_text)}}</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ (isset($data) && $employee->id == $data['employee_id']) ? 'selected' : '' }}>{{ ucfirst($employee->first_name).' '.ucfirst($employee->last_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        @endif
                        <div class="col-sm-6 col-xl-2 col-lg-6 p-2 appointment-date-filter">
                            <div class="form-group ">
                                <label for="date" class="form-label">{{ __('Appointment Start Date') }}: </label>
                                <input type="text" class="form-control custom-control date custom-format" id="startdate" min="{{date($custom->date_format)}}" autocomplete="off" 
                                value="{{ isset($data) ? $data['startdate'] : '' }}" name="startdate" data-date-format="{{ $custom->date_format }}" data-wizard-validate-date="true" placeholder="{{ __('Please Select Date') }}">
                                <span class=" error-message" id="err-date"></span>
                            </div>
                        </div>

                    
                        <div class="col-sm-6 col-xl-2 col-lg-6 col-lg-2 p-2 appointment-date-filter">
                            <div class="form-group">
                                <label for="date" class="form-label">{{ __('Appointment End Date') }}: </label>
                                <input type="text" class="form-control custom-control date custom-format" id="enddate" max="{{date($custom->date_format)}}" autocomplete="off" 
                                value="{{ isset($data) ? $data['enddate'] : '' }}" name="enddate" data-date-format="{{ $custom->date_format }}" data-wizard-validate-date="true" placeholder="{{ __('Please Select Date') }}">
                                <span class=" error-message" id="err-date"></span>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-xl-2 col-lg-6 p-2 appointment-date-filter">
                            <div class="form-group">
                                <label for="status" class="form-label"> {{ __('Status') }}: </label>
                                <select name="status" id="status" class="form-control custom-control" >
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="approved" {{ ( isset($data) && 'approved' == $data['status']) ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                <option value="cancel" {{ (  isset($data) && 'cancel' == $data['status']) ? 'selected' : '' }}>{{ __('Cancel') }}</option>
                                <option value="pending" {{ (  isset($data) &&  'pending' == $data['status']) ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2 col-lg-6 mt-sm-1 p-2 appointment-date-filter">
                            <input type="submit" class="btn btn-primary filter truncate" name="filter" value="{{ __('Apply Filter') }}" id="filter" title="{{ __('Apply Filter') }}">
                            <input type="button" class="btn btn-primary filter" name="reset" value="{{ __('Reset') }}" id="reset">
                        </div>
                        
                    </div>
                </form>
    
                <div class="table-style">
                    <div class="table-responsive">
                        <table class="table table-hover data-table" id="appointment-table">
                            <thead>
                            <tr>
                                <th>{{ __('SR No') }}.</th>
                                <th>{{ucfirst($custom->custom_field_service)}}</th>
                                @if($custom->employees == 1)
                                    <th>{{ucfirst($custom->custom_field_text)}}</th>
                                @endif
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th>{{ __('Appointment Date') }}</th>
                                <th>{{ __('Start time') }}</th>
                                <th>{{ __('Finish time') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Comment') }}</th>
                                <th class="custom-column">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <th>{{ $rowIndex++}}</th>
                                    <td>{{ $appointment->service_id }}</td>
                                    @if($custom->employees == 1)
                                        <td>{{ !empty($appointment->employee) ? ucfirst($appointment->employee->first_name).' '.ucfirst($appointment->employee->last_name) : 'Employee Not Available' }}</td>
                                    @endif
                                    <td>{{ !empty($appointment->user) ?ucfirst($appointment->user->first_name).' '.ucfirst($appointment->user->last_name) : 'User Not Available' }}</td>
                                    <td>{{ date($custom->date_format,strtotime($appointment->created_at)) }}</td>
                                    <td>{{ date($custom->date_format,strtotime($appointment->date)) }}</td>
                                    <td>{{ date('h:i A',strtotime($appointment->start_time)) }}</td>
                                    <td>{{ date('h:i A',strtotime($appointment->finish_time)) }}</td>
                                    @if($appointment->status == 'approved')
                                        <td><span class="badge bg-success">{{ ucfirst($appointment->status) }}</span></td>
                                    @endif
                                    @if($appointment->status == 'pending')
                                        <td><span class="badge bg-warning">{{ ucfirst($appointment->status) }}</span></td>
                                    @endif
                                    @if($appointment->status == 'cancel')
                                        <td><span class="badge bg-danger">{{ ucfirst($appointment->status) }}</span></td>
                                    @endif
                                    @if($appointment->status == 'completed')
                                        <td><span class="badge bg-info">{{ ucfirst($appointment->status) }}</span></td>
                                    @endif
                                    <td>{{ $appointment->comments }}</td>
                                    <td>
                                        <a class="btn btn-default btn-lg mt-0" href="{{ route('appointments.show',$appointment->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a class="btn btn-default btn-lg mt-0" href="{{ route('paymentview',$appointment->payment->id) }}"><span class="fa fa-inr"></span></a>
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
<script src="{{asset('backend/js/appointment.js') }}"></script>
@endsection
